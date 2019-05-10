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
use Fxp\Component\Mailer\Loader\TemplateLayoutLoaderChain;
use Fxp\Component\Mailer\Loader\TemplateLayoutLoaderInterface;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for chain template mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateLayoutLoaderChainTest extends TestCase
{
    public function testLoad(): void
    {
        $template = $this->getMockBuilder(TemplateLayoutInterface::class)->getMock();

        $loader1 = $this->getMockBuilder(TemplateLayoutLoaderInterface::class)->getMock();
        $loader1->expects($this->once())
            ->method('load')
            ->willThrowException(new UnknownLayoutException('test'))
        ;

        $loader2 = $this->getMockBuilder(TemplateLayoutLoaderInterface::class)->getMock();
        $loader2->expects($this->once())
            ->method('load')
            ->will($this->returnValue($template))
        ;

        $chainLoader = new TemplateLayoutLoaderChain([$loader1, $loader2]);

        $this->assertSame($template, $chainLoader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        $loader = new TemplateLayoutLoaderChain([]);

        $loader->load('test');
    }
}
