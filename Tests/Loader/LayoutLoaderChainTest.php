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

use Fxp\Component\Mailer\Exception\UnknownLayoutException;
use Fxp\Component\Mailer\Loader\LayoutLoaderChain;
use Fxp\Component\Mailer\Loader\LayoutLoaderInterface;
use Fxp\Component\Mailer\Model\LayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for chain mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class LayoutLoaderChainTest extends TestCase
{
    public function testLoad(): void
    {
        $template = $this->getMockBuilder(LayoutInterface::class)->getMock();

        $loader1 = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        $loader1->expects($this->once())
            ->method('load')
            ->willThrowException(new UnknownLayoutException('test'))
        ;

        $loader2 = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        $loader2->expects($this->once())
            ->method('load')
            ->will($this->returnValue($template))
        ;

        $chainLoader = new LayoutLoaderChain([$loader1, $loader2]);

        $this->assertSame($template, $chainLoader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        $loader = new LayoutLoaderChain([]);

        $loader->load('test');
    }
}
