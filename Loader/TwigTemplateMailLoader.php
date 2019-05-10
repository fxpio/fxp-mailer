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

use Fxp\Component\Mailer\Model\TemplateMailInterface;
use Fxp\Component\Mailer\Model\TemplateMailTranslationInterface;
use Fxp\Component\Mailer\Model\TwigTemplateMail;
use Fxp\Component\Mailer\Model\TwigTemplateMailTranslation;
use Fxp\Component\Mailer\Util\ConfigUtil;

/**
 * Twig File template mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TwigTemplateMailLoader extends AbstractFileTemplateMailLoader
{
    /**
     * {@inheritdoc}
     */
    protected function createMail(array $config): TemplateMailInterface
    {
        /** @var TwigTemplateMail $mail */
        $mail = parent::createMail($config);
        $mail->setFile(ConfigUtil::getValue($config, 'file'));

        return $mail;
    }

    /**
     * {@inheritdoc}
     */
    protected function createMailTranslation(TemplateMailInterface $mail, array $config): TemplateMailTranslationInterface
    {
        /** @var TwigTemplateMailTranslation $translation */
        $translation = parent::createMailTranslation($mail, $config);
        $translation->setFile(ConfigUtil::getValue($config, 'file'));

        return $translation;
    }

    /**
     * {@inheritdoc}
     */
    protected function newMailInstance(): TemplateMailInterface
    {
        return new TwigTemplateMail();
    }

    /**
     * {@inheritdoc}
     */
    protected function newMailTranslationInstance(TemplateMailInterface $mail): TemplateMailTranslationInterface
    {
        return new TwigTemplateMailTranslation($mail);
    }
}
