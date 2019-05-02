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

use Fxp\Component\Mailer\Loader\LayoutLoaderInterface;
use Fxp\Component\Mailer\Loader\TwigMailLoader;
use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tests for twig mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TwigMailLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        // layout
        $templateLayout = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $templateLayout->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'))
        ;
        $templateLayout->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true))
        ;

        // loader
        /** @var LayoutLoaderInterface|\PHPUnit_Framework_MockObject_MockObject $layoutLoader */
        $layoutLoader = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        $layoutLoader->expects($this->once())
            ->method('load')
            ->will($this->returnValue($templateLayout))
        ;

        /** @var KernelInterface|\PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $template = [
            'name' => 'test',
            'layout' => 'test',
            'file' => '@AcmeDemoBundle/Resources/loaders/mail.html.twig',
            'translations' => [
                [
                    'locale' => 'fr',
                    'file' => '@AcmeDemoBundle/Resources/loaders/mail.fr.html.twig',
                ],
            ],
        ];

        $kernel->expects($this->at(0))
            ->method('locateResource')
            ->with('@AcmeDemoBundle/Resources/loaders/mail.html.twig')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/mail.html.twig'))
        ;

        $kernel->expects($this->at(1))
            ->method('locateResource')
            ->with('@AcmeDemoBundle/Resources/loaders/mail.fr.html.twig')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/mail.fr.html.twig'))
        ;

        $loader = new TwigMailLoader([$template], $layoutLoader, $kernel);

        $this->assertInstanceOf(MailInterface::class, $loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownMailException::class);
        $this->expectExceptionMessage('The "test" mail template does not exist with the "all" type');

        /** @var LayoutLoaderInterface $layoutLoader */
        $layoutLoader = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        /** @var KernelInterface $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();

        $loader = new TwigMailLoader([], $layoutLoader, $kernel);

        $loader->load('test');
    }
}
