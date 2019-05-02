<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Twig\Extension;

use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Exception\UnknownLayoutException;
use Fxp\Component\Mailer\Loader\LayoutLoaderInterface;
use Fxp\Component\Mailer\MailRenderedInterface;
use Fxp\Component\Mailer\MailTemplaterInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\TwigLayout;
use Fxp\Component\Mailer\Twig\TokenParser\LayoutTokenParser;
use Fxp\Component\Mailer\Util\TranslationUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Use the mail templater directly in twig template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TemplaterExtension extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    public $container;

    /**
     * @var null|MailTemplaterInterface
     */
    protected $templater;

    /**
     * @var LayoutLoaderInterface
     */
    protected $layoutLoader;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var array[]
     */
    protected $cache;

    /**
     * Constructor.
     *
     * @param LayoutLoaderInterface $layoutLoader The layout loader
     * @param TranslatorInterface   $translator   The translator
     */
    public function __construct(LayoutLoaderInterface $layoutLoader, TranslatorInterface $translator)
    {
        $this->layoutLoader = $layoutLoader;
        $this->translator = $translator;
        $this->cache = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('fxp_mailer_render_subject', [$this, 'renderSubject']),
            new TwigFunction('fxp_mailer_render_html', [$this, 'renderHtml'], ['is_safe' => ['html']]),
            new TwigFunction('fxp_mailer_render_text', [$this, 'renderPlainText']),
            new TwigFunction('fxp_mailer_mail_rendered', [$this, 'getMailRendered']),
            new TwigFunction('fxp_mailer_clean', [$this, 'cleanRendered']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return [
            new LayoutTokenParser(),
        ];
    }

    /**
     * Render the subject of mail template.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return string
     */
    public function renderSubject($template, array $variables = [], $type = MailTypes::TYPE_ALL)
    {
        return $this->getMailRendered($template, $variables, $type)->getSubject();
    }

    /**
     * Render the mail template in html.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return string
     */
    public function renderHtml($template, array $variables = [], $type = MailTypes::TYPE_ALL)
    {
        return $this->getMailRendered($template, $variables, $type)->getHtmlBody();
    }

    /**
     * Render the mail template in plain text.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return string
     */
    public function renderPlainText($template, array $variables = [], $type = MailTypes::TYPE_ALL)
    {
        return $this->getMailRendered($template, $variables, $type)->getBody();
    }

    /**
     * Render the mail template.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return MailRenderedInterface
     */
    public function getMailRendered($template, array $variables = [], $type = MailTypes::TYPE_ALL)
    {
        $id = $this->getCacheId($template, $variables, $type);

        if (!isset($this->cache[$template][$id])) {
            $this->cache[$template][$id] = $this->getTemplater()->render($template, $variables, $type);
        }

        return $this->cache[$template][$id];
    }

    /**
     * @param string $template The mail template name
     */
    public function cleanRendered($template): void
    {
        unset($this->cache[$template]);
    }

    /**
     * Get the translated layout.
     *
     * @param string $layout The name of layout
     *
     * @throws UnknownLayoutException   When the layout template does not exist
     * @throws InvalidArgumentException When the layout is not a twig layout
     *
     * @return TwigLayout
     */
    public function getTranslatedLayout($layout)
    {
        $template = $this->layoutLoader->load($layout);
        $template = TranslationUtil::translateLayout($template, $this->getTemplater()->getLocale(), $this->translator);

        if (!$template instanceof TwigLayout) {
            $msg = 'The "%s" layout is not a twig layout';

            throw new InvalidArgumentException(sprintf($msg, $layout));
        }

        return $template;
    }

    /**
     * Get the id for the cache.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return string
     */
    protected function getCacheId($template, array $variables = [], $type = MailTypes::TYPE_ALL)
    {
        $serialize = serialize($variables);

        return sha1($template.'&&'.$serialize.'&&'.$type);
    }

    /**
     * Get the templater.
     *
     * @return MailTemplaterInterface
     */
    protected function getTemplater()
    {
        if (null !== $this->container) {
            $this->templater = $this->container->get('fxp_mailer.mail_templater');
            $this->container = null;
        }

        return $this->templater;
    }
}
