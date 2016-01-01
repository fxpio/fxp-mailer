<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\MailerBundle\Tests\DependencyInjection\Compiler;

use Sonatra\Bundle\MailerBundle\DependencyInjection\Compiler\TemplatePass;
use Sonatra\Bundle\MailerBundle\Loader\ArrayLayoutLoader;
use Sonatra\Bundle\MailerBundle\Model\Layout;
use Sonatra\Bundle\MailerBundle\Model\Mail;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for template loader pass.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TemplatePassTest extends KernelTestCase
{
    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @var TemplatePass
     */
    protected $pass;

    protected function setUp()
    {
        $this->rootDir = sys_get_temp_dir().'/sonatra_mailer_bundle_template_loader_pass';
        $this->fs = new Filesystem();
        $this->pass = new TemplatePass();
    }

    protected function tearDown()
    {
        $this->fs->remove($this->rootDir);
        $this->pass = null;
    }

    public function testProcessWithoutService()
    {
        $container = $this->getContainer();

        $this->pass->process($container);
        $this->assertFalse($container->has('sonatra_mailer.loader.layout_array'));
        $this->assertFalse($container->has('sonatra_mailer.loader.mail_array'));
    }

    public function testProcessWithAddTemplates()
    {
        $container = $this->getContainer();
        $layoutLoaderDef = new Definition(ArrayLayoutLoader::class);
        $mailLoaderDef = new Definition(ArrayLayoutLoader::class);

        $layoutLoaderDef->setArguments(array(array()));
        $mailLoaderDef->setArguments(array(array()));

        $container->setDefinition('sonatra_mailer.loader.layout_array', $layoutLoaderDef);
        $container->setDefinition('sonatra_mailer.loader.mail_array', $mailLoaderDef);

        $this->assertCount(0, $layoutLoaderDef->getArgument(0));
        $this->assertCount(0, $mailLoaderDef->getArgument(0));

        // add mocks
        $layoutDef = new Definition(Layout::class);
        $mailDef = new Definition(Mail::class);
        $layoutDef->addTag('sonatra_mailer.layout');
        $mailDef->addTag('sonatra_mailer.mail');

        $container->setDefinition('test.layout', $layoutDef);
        $container->setDefinition('test.mail', $mailDef);

        // test
        $this->pass->process($container);

        $this->assertCount(1, $layoutLoaderDef->getArgument(0));
        $this->assertCount(1, $mailLoaderDef->getArgument(0));
    }

    /**
     * Gets the container.
     *
     * @return ContainerBuilder
     */
    protected function getContainer()
    {
        $container = new ContainerBuilder(new ParameterBag(array(
            'kernel.cache_dir' => $this->rootDir,
            'kernel.debug' => false,
            'kernel.environment' => 'test',
            'kernel.name' => 'kernel',
            'kernel.root_dir' => $this->rootDir,
            'kernel.charset' => 'UTF-8',
            'kernel.bundles' => array(),
        )));

        return $container;
    }
}