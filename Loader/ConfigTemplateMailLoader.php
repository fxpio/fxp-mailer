<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Loader;

use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\TemplateMail;
use Fxp\Component\Mailer\Model\TemplateMailInterface;
use Fxp\Component\Mailer\Model\TemplateMailTranslation;
use Fxp\Component\Mailer\Model\TemplateMailTranslationInterface;
use Fxp\Component\Mailer\Util\ConfigUtil;

/**
 * Config template mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ConfigTemplateMailLoader extends ArrayTemplateMailLoader
{
    /**
     * @var TemplateLayoutLoaderInterface
     */
    protected $layoutLoader;

    /**
     * Constructor.
     *
     * @param array[]                       $configs      The mail config
     * @param TemplateLayoutLoaderInterface $layoutLoader The layout loader
     */
    public function __construct(array $configs, TemplateLayoutLoaderInterface $layoutLoader)
    {
        $this->layoutLoader = $layoutLoader;
        $mails = [];

        foreach ($configs as $config) {
            $mails[] = $this->createMail($config);
        }

        parent::__construct($mails);
    }

    /**
     * Create the mail.
     *
     * @param array $config
     *
     * @return TemplateMailInterface
     */
    protected function createMail(array $config): TemplateMailInterface
    {
        $mail = $this->newMailInstance();

        $mail->setName(ConfigUtil::getValue($config, 'name'));
        $mail->setLabel(ConfigUtil::getValue($config, 'label'));
        $mail->setDescription(ConfigUtil::getValue($config, 'description'));
        $mail->setType(ConfigUtil::getValue($config, 'type', MailTypes::TYPE_ALL));
        $mail->setEnabled(ConfigUtil::getValue($config, 'enabled', true));
        $mail->setSubject(ConfigUtil::getValue($config, 'subject'));
        $mail->setHtmlBody(ConfigUtil::getValue($config, 'html_body'));
        $mail->setBody(ConfigUtil::getValue($config, 'body'));
        $mail->setTranslationDomain(ConfigUtil::getValue($config, 'translation_domain'));

        if (isset($config['layout'])) {
            $mail->setLayout($this->layoutLoader->load($config['layout']));
        }

        if (isset($config['translations']) && \is_array($config['translations'])) {
            foreach ($config['translations'] as $translation) {
                $mail->addTranslation($this->createMailTranslation($mail, $translation));
            }
        }

        return $mail;
    }

    /**
     * Create a mail translation.
     *
     * @param TemplateMailInterface $mail   The mail
     * @param array                 $config The config of mail translation
     *
     * @return TemplateMailTranslationInterface
     */
    protected function createMailTranslation(TemplateMailInterface $mail, array $config): TemplateMailTranslationInterface
    {
        $translation = $this->newMailTranslationInstance($mail);
        $translation->setLocale(ConfigUtil::getValue($config, 'locale'));
        $translation->setLabel(ConfigUtil::getValue($config, 'label'));
        $translation->setDescription(ConfigUtil::getValue($config, 'description'));
        $translation->setSubject(ConfigUtil::getValue($config, 'subject'));
        $translation->setHtmlBody(ConfigUtil::getValue($config, 'html_body'));
        $translation->setBody(ConfigUtil::getValue($config, 'body'));

        return $translation;
    }

    /**
     * Create a new instance of mail.
     *
     * @return TemplateMailInterface
     */
    protected function newMailInstance(): TemplateMailInterface
    {
        return new TemplateMail();
    }

    /**
     * Create a new instance of mail translation.
     *
     * @param TemplateMailInterface $mail The mail
     *
     * @return TemplateMailTranslationInterface
     */
    protected function newMailTranslationInstance(TemplateMailInterface $mail): TemplateMailTranslationInterface
    {
        return new TemplateMailTranslation($mail);
    }
}
