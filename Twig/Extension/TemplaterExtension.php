<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\MailerBundle\Twig\Extension;

use Sonatra\Bundle\MailerBundle\Exception\InvalidArgumentException;
use Sonatra\Bundle\MailerBundle\Exception\UnknownLayoutException;
use Sonatra\Bundle\MailerBundle\Loader\LayoutLoaderInterface;
use Sonatra\Bundle\MailerBundle\Mailer\MailRenderedInterface;
use Sonatra\Bundle\MailerBundle\Mailer\MailTemplaterInterface;
use Sonatra\Bundle\MailerBundle\MailTypes;
use Sonatra\Bundle\MailerBundle\Model\TwigLayout;
use Sonatra\Bundle\MailerBundle\Twig\TokenParser\LayoutTokenParser;
use Sonatra\Bundle\MailerBundle\Util\TranslationUtil;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Use the mail templater directly in twig template.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TemplaterExtension extends \Twig_Extension
{
    /**
     * @var MailTemplaterInterface
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
     * Constructor.
     *
     * @param MailTemplaterInterface $templater    The templater
     * @param LayoutLoaderInterface  $layoutLoader The layout loader
     * @param TranslatorInterface    $translator   The translator
     */
    public function __construct(MailTemplaterInterface $templater, LayoutLoaderInterface $layoutLoader,
                                TranslatorInterface $translator)
    {
        $this->templater = $templater;
        $this->layoutLoader = $layoutLoader;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('sonatra_mailer_render', array($this, 'renderHtml'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('sonatra_mailer_render_plain', array($this, 'renderPlainText')),
            new \Twig_SimpleFunction('sonatra_mailer_mail_rendered', array($this, 'getMailRendered')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array(
            new LayoutTokenParser(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sonatra_mailer_templater';
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
    public function renderHtml($template, array $variables = array(), $type = MailTypes::TYPE_ALL)
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
    public function renderPlainText($template, array $variables = array(), $type = MailTypes::TYPE_ALL)
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
    public function getMailRendered($template, array $variables = array(), $type = MailTypes::TYPE_ALL)
    {
        return $this->templater->render($template, $variables, $type);
    }

    /**
     * Get the translated layout.
     *
     * @param string $layout The name of layout
     *
     * @return TwigLayout
     *
     * @throws UnknownLayoutException   When the layout template does not exist
     * @throws InvalidArgumentException When the layout is not a twig layout
     */
    public function getTranslatedLayout($layout)
    {
        $template = $this->layoutLoader->load($layout);
        $template = TranslationUtil::translateLayout($template, $this->templater->getLocale(), $this->translator);

        if (!$template instanceof TwigLayout) {
            $msg = 'The "%s" layout is not a twig layout';
            throw new InvalidArgumentException(sprintf($msg, $layout));
        }

        return $template;
    }
}
