<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Loader;

use Fxp\Component\Mailer\Loader\TwigTemplateLayoutLoader;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tests for twig template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TwigTemplateLayoutLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        /** @var KernelInterface|\PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $template = [
            'name' => 'test',
            'file' => '@AcmeDemoBundle/Resources/loaders/layout.html.twig',
            'translations' => [
                [
                    'locale' => 'fr',
                    'file' => '@AcmeDemoBundle/Resources/loaders/layout.fr.html.twig',
                ],
            ],
        ];

        $kernel->expects($this->at(0))
            ->method('locateResource')
            ->with('@AcmeDemoBundle/Resources/loaders/layout.html.twig')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/layout.html.twig'))
        ;

        $kernel->expects($this->at(1))
            ->method('locateResource')
            ->with('@AcmeDemoBundle/Resources/loaders/layout.fr.html.twig')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/layout.fr.html.twig'))
        ;

        $loader = new TwigTemplateLayoutLoader([$template], $kernel);

        $this->assertInstanceOf(TemplateLayoutInterface::class, $loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        /** @var KernelInterface $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();

        $loader = new TwigTemplateLayoutLoader([], $kernel);

        $loader->load('test');
    }
}
