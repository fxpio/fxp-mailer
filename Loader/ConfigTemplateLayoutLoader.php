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

use Fxp\Component\Mailer\Model\TemplateLayout;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use Fxp\Component\Mailer\Model\TemplateLayoutTranslation;
use Fxp\Component\Mailer\Model\TemplateLayoutTranslationInterface;
use Fxp\Component\Mailer\Util\ConfigUtil;

/**
 * Config template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ConfigTemplateLayoutLoader extends ArrayTemplateLayoutLoader
{
    /**
     * Constructor.
     *
     * @param array[] $configs The layout config
     */
    public function __construct(array $configs)
    {
        $layouts = [];

        foreach ($configs as $config) {
            $layouts[] = $this->createLayout($config);
        }

        parent::__construct($layouts);
    }

    /**
     * Create the layout.
     *
     * @param array $config The config of layout
     *
     * @return TemplateLayoutInterface
     */
    protected function createLayout(array $config): TemplateLayoutInterface
    {
        $layout = $this->newLayoutInstance();

        $layout->setName(ConfigUtil::getValue($config, 'name'));
        $layout->setLabel(ConfigUtil::getValue($config, 'label'));
        $layout->setDescription(ConfigUtil::getValue($config, 'description'));
        $layout->setEnabled(ConfigUtil::getValue($config, 'enabled', true));
        $layout->setBody(ConfigUtil::getValue($config, 'body'));
        $layout->setTranslationDomain(ConfigUtil::getValue($config, 'translation_domain'));

        if (isset($config['translations']) && \is_array($config['translations'])) {
            foreach ($config['translations'] as $translation) {
                $layout->addTranslation($this->createLayoutTranslation($layout, $translation));
            }
        }

        return $layout;
    }

    /**
     * Create a layout translation.
     *
     * @param TemplateLayoutInterface $layout The layout
     * @param array                   $config The config of layout translation
     *
     * @return TemplateLayoutTranslationInterface
     */
    protected function createLayoutTranslation(TemplateLayoutInterface $layout, array $config): TemplateLayoutTranslationInterface
    {
        $translation = $this->newLayoutTranslationInstance($layout);
        $translation->setLocale(ConfigUtil::getValue($config, 'locale'));
        $translation->setLabel(ConfigUtil::getValue($config, 'label'));
        $translation->setDescription(ConfigUtil::getValue($config, 'description'));
        $translation->setBody(ConfigUtil::getValue($config, 'body'));

        return $translation;
    }

    /**
     * Create a new instance of layout.
     *
     * @return TemplateLayoutInterface
     */
    protected function newLayoutInstance(): TemplateLayoutInterface
    {
        return new TemplateLayout();
    }

    /**
     * Create a new instance of layout translation.
     *
     * @param TemplateLayoutInterface $layout The layout
     *
     * @return TemplateLayoutTranslationInterface
     */
    protected function newLayoutTranslationInstance(TemplateLayoutInterface $layout): TemplateLayoutTranslationInterface
    {
        return new TemplateLayoutTranslation($layout);
    }
}
