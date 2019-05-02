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

use Fxp\Component\Mailer\Loader\YamlLayoutLoader;
use Fxp\Component\Mailer\Model\LayoutInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tests for yaml layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class YamlLayoutLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        /** @var KernelInterface|\PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $template = '@AcmeDemoBundle/Resources/loaders/layout.yml';

        $kernel->expects($this->once())
            ->method('locateResource')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/layout.yml'))
        ;

        $loader = new YamlLayoutLoader([$template], $kernel);

        $this->assertInstanceOf(LayoutInterface::class, $loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        /** @var KernelInterface $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();

        $loader = new YamlLayoutLoader([], $kernel);

        $loader->load('test');
    }
}
