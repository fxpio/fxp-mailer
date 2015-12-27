<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\MailerBundle\DependencyInjection;

use Sonatra\Bundle\MailerBundle\Loader\ConfigLayoutLoader;
use Sonatra\Bundle\MailerBundle\Loader\ConfigMailLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class SonatraMailerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // model classes
        $container->setParameter('sonatra_mailer.layout_class', $config['layout_class']);
        $container->setParameter('sonatra_mailer.mail_class', $config['layout_class']);

        $loader->load('templater.xml');
        $loader->load('doctrine_loader.xml');

        $this->addTemplates($container, 'layout', ConfigLayoutLoader::class, $config['layout_templates']);
        $this->addTemplates($container, 'mail', ConfigMailLoader::class, $config['mail_templates']);
    }

    /**
     * Add the templates.
     *
     * @param ContainerBuilder $container The container
     * @param string           $type      The template type
     * @param string           $class     The class name of config loader
     * @param array            $templates The template configs of layouts
     */
    protected function addTemplates(ContainerBuilder $container, $type, $class, array $templates)
    {
        $def = new Definition($class);
        $def->setArguments(array($templates));
        $def->addTag(sprintf('sonatra_mailer.%s_loader', $type));

        $container->setDefinition(sprintf('sonatra_mailer.loader.config_%s', $type), $def);
    }
}
