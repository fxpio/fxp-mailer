<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer;

use Fxp\Component\Mailer\Event\FilterPostRenderEvent;
use Fxp\Component\Mailer\Event\FilterPreRenderEvent;
use Fxp\Component\Mailer\Loader\MailLoaderInterface;
use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\MailInterface;
use Fxp\Component\Mailer\Model\TwigTemplateInterface;
use Fxp\Component\Mailer\Util\MailUtil;
use Fxp\Component\Mailer\Util\TranslationUtil;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * The mail templater.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailTemplater implements MailTemplaterInterface
{
    /**
     * @var MailLoaderInterface
     */
    protected $loader;

    /**
     * @var \Twig_Environment
     */
    protected $renderer;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var null|TranslatorInterface
     */
    protected $translator;

    /**
     * @var string
     */
    protected $locale;

    /**
     * Constructor.
     *
     * @param MailLoaderInterface      $loader     The mail loader
     * @param \Twig_Environment        $renderer   The twig environment
     * @param EventDispatcherInterface $dispatcher The event dispatcher
     */
    public function __construct(
        MailLoaderInterface $loader,
        \Twig_Environment $renderer,
        EventDispatcherInterface $dispatcher
    ) {
        $this->loader = $loader;
        $this->renderer = $renderer;
        $this->locale = \Locale::getDefault();
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $template, array $variables = [], string $type = MailTypes::TYPE_ALL): MailRenderedInterface
    {
        $preEvent = new FilterPreRenderEvent($template, $variables, $type);
        $this->dispatcher->dispatch(MailerEvents::TEMPLATE_PRE_RENDER, $preEvent);

        $mail = $this->getTranslatedMail($preEvent->getTemplate(), $preEvent->getType());
        $mailRendered = $this->doRender($preEvent, $mail);

        $postEvent = new FilterPostRenderEvent($mailRendered);
        $this->dispatcher->dispatch(MailerEvents::TEMPLATE_POST_RENDER, $postEvent);

        return $postEvent->getMailRendered();
    }

    /**
     * Render the mail.
     *
     * @param FilterPreRenderEvent $preEvent The template pre event
     * @param MailInterface        $mail     The mail
     *
     * @throws
     *
     * @return MailRendered
     */
    protected function doRender(FilterPreRenderEvent $preEvent, MailInterface $mail): MailRendered
    {
        $variables = $preEvent->getVariables();
        $variables['_mail_type'] = $mail->getType();
        $variables['_layout'] = null !== $mail->getLayout() ? $mail->getLayout()->getName() : null;
        $subject = $this->renderTemplate($mail->getSubject(), $mail, $variables);
        $variables['_subject'] = $subject;
        $htmlBody = $this->renderTemplate($mail->getHtmlBody(), $mail, $variables);
        $variables['_html_body'] = $htmlBody;
        $body = $this->renderTemplate($mail->getBody(), $mail, $variables);
        $variables['_body'] = $body;

        $layout = $this->getTranslatedLayout($mail);

        if (null !== $layout && null !== ($lBody = $layout->getBody()) && !MailUtil::isRootBody($htmlBody)) {
            $htmlBody = $this->renderTemplate($lBody, $layout, $variables);
        }

        return new MailRendered($mail, $subject, $htmlBody, $body);
    }

    /**
     * Get the translated mail.
     *
     * @param string $template The mail template name
     * @param string $type     The mail type defined in MailTypes::TYPE_*
     *
     * @return MailInterface
     */
    protected function getTranslatedMail(string $template, string $type): MailInterface
    {
        $mail = $this->loader->load($template, $type);

        return TranslationUtil::translateMail($mail, $this->getLocale(), $this->translator);
    }

    /**
     * Get the translated layout of mail.
     *
     * @param MailInterface $mail The mail
     *
     * @return null|LayoutInterface
     */
    protected function getTranslatedLayout(MailInterface $mail): ?LayoutInterface
    {
        $layout = $mail->getLayout();

        if (null !== $layout) {
            $layout = TranslationUtil::translateLayout($layout, $this->getLocale(), $this->translator);
        }

        return $layout;
    }

    /**
     * Render the template.
     *
     * @param string                        $template         The template string
     * @param LayoutInterface|MailInterface $templateInstance The template instance
     * @param array                         $variables        The variables of template
     *
     * @throws \Exception
     * @throws \Throwable
     *
     * @return null|string The rendered template
     */
    protected function renderTemplate(string $template, $templateInstance, array $variables = []): ?string
    {
        $rendered = null;

        if (null !== $template) {
            if ($templateInstance instanceof TwigTemplateInterface) {
                $tpl = $this->renderer->load($templateInstance->getFile());
                $rendered = $tpl->renderBlock($template, $variables);
                $rendered = '' === $rendered ? null : $rendered;
            } else {
                $tpl = $this->renderer->createTemplate($rendered);
                $rendered = $tpl->render($variables);
            }
        }

        return $rendered;
    }
}
