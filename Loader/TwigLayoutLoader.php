<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Loader;

use Sonatra\Component\Mailer\Model\LayoutInterface;
use Sonatra\Component\Mailer\Model\TwigLayout;
use Sonatra\Component\Mailer\Model\TwigLayoutTranslation;
use Sonatra\Component\Mailer\Util\ConfigUtil;

/**
 * Twig File layout loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TwigLayoutLoader extends AbstractFileLayoutLoader
{
    /**
     * {@inheritdoc}
     */
    protected function createLayout(array $config)
    {
        /* @var $layout TwigLayout */
        $layout = parent::createLayout($config);
        $layout->setFile(ConfigUtil::getValue($config, 'file'));

        return $layout;
    }

    /**
     * {@inheritdoc}
     */
    protected function createLayoutTranslation(LayoutInterface $layout, array $config)
    {
        /* @var $translation TwigLayoutTranslation */
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
