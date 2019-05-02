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

use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\TwigLayout;
use Fxp\Component\Mailer\Model\TwigLayoutTranslation;
use Fxp\Component\Mailer\Util\ConfigUtil;

/**
 * Twig File layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TwigLayoutLoader extends AbstractFileLayoutLoader
{
    /**
     * {@inheritdoc}
     */
    protected function createLayout(array $config)
    {
        /** @var TwigLayout $layout */
        $layout = parent::createLayout($config);
        $layout->setFile(ConfigUtil::getValue($config, 'file'));

        return $layout;
    }

    /**
     * {@inheritdoc}
     */
    protected function createLayoutTranslation(LayoutInterface $layout, array $config)
    {
        /** @var TwigLayoutTranslation $translation */
        $translation = parent::createLayoutTranslation($layout, $config);
        $translation->setFile(ConfigUtil::getValue($config, 'file'));

        return $translation;
    }

    /**
     * {@inheritdoc}
     */
    protected function newLayoutInstance()
    {
        return new TwigLayout();
    }

    /**
     * {@inheritdoc}
     */
    protected function newLayoutTranslationInstance(LayoutInterface $layout)
    {
        return new TwigLayoutTranslation($layout);
    }
}
