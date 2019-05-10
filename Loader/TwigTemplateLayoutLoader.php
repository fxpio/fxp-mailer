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

use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use Fxp\Component\Mailer\Model\TemplateLayoutTranslationInterface;
use Fxp\Component\Mailer\Model\TwigTemplateLayout;
use Fxp\Component\Mailer\Model\TwigTemplateLayoutTranslation;
use Fxp\Component\Mailer\Util\ConfigUtil;

/**
 * Twig File template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TwigTemplateLayoutLoader extends AbstractFileTemplateLayoutLoader
{
    /**
     * {@inheritdoc}
     */
    protected function createLayout(array $config): TemplateLayoutInterface
    {
        /** @var TwigTemplateLayout $layout */
        $layout = parent::createLayout($config);
        $layout->setFile(ConfigUtil::getValue($config, 'file'));

        return $layout;
    }

    /**
     * {@inheritdoc}
     */
    protected function createLayoutTranslation(TemplateLayoutInterface $layout, array $config): TemplateLayoutTranslationInterface
    {
        /** @var TwigTemplateLayoutTranslation $translation */
        $translation = parent::createLayoutTranslation($layout, $config);
        $translation->setFile(ConfigUtil::getValue($config, 'file'));

        return $translation;
    }

    /**
     * {@inheritdoc}
     */
    protected function newLayoutInstance(): TemplateLayoutInterface
    {
        return new TwigTemplateLayout();
    }

    /**
     * {@inheritdoc}
     */
    protected function newLayoutTranslationInstance(TemplateLayoutInterface $layout): TemplateLayoutTranslationInterface
    {
        return new TwigTemplateLayoutTranslation($layout);
    }
}
