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
use Fxp\Component\Mailer\Loader\YamlMailLoader;
use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tests for yaml mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class YamlMailLoaderTest extends TestCase
{
    public function testLoad()
    {
        // layout
        $templateLayout = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $templateLayout->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'));
        $templateLayout->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        // loader
        /* @var LayoutLoaderInterface|\PHPUnit_Framework_MockObject_MockObject $layoutLoader */
        $layoutLoader = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        $layoutLoader->expects($this->once())
            ->method('load')
            ->will($this->returnValue($templateLayout));

        /* @var KernelInterface|\PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $template = '@AcmeDemoBundle/Resources/loaders/mail.yml';

        $kernel->expects($this->once())
            ->method('locateResource')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/mail.yml'));

        $loader = new YamlMailLoader([$template], $layoutLoader, $kernel);

        $this->assertInstanceOf(MailInterface::class, $loader->load('test'));
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\UnknownMailException
     * @expectedExceptionMessage The "test" mail template does not exist with the "all" type
     */
    public function testLoadUnknownTemplate()
    {
        /* @var LayoutLoaderInterface $layoutLoader */
        $layoutLoader = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        /* @var KernelInterface $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();

        $loader = new YamlMailLoader([], $layoutLoader, $kernel);

        $loader->load('test');
    }
}
