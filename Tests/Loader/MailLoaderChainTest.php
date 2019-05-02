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

use Fxp\Component\Mailer\Exception\UnknownMailException;
use Fxp\Component\Mailer\Loader\MailLoaderChain;
use Fxp\Component\Mailer\Loader\MailLoaderInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for chain layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class MailLoaderChainTest extends TestCase
{
    public function testLoad(): void
    {
        $template = $this->getMockBuilder(MailInterface::class)->getMock();

        $loader1 = $this->getMockBuilder(MailLoaderInterface::class)->getMock();
        $loader1->expects($this->once())
            ->method('load')
            ->willThrowException(new UnknownMailException('test', MailTypes::TYPE_ALL))
        ;

        $loader2 = $this->getMockBuilder(MailLoaderInterface::class)->getMock();
        $loader2->expects($this->once())
            ->method('load')
            ->will($this->returnValue($template))
        ;

        $chainLoader = new MailLoaderChain([$loader1, $loader2]);

        $this->assertSame($template, $chainLoader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownMailException::class);
        $this->expectExceptionMessage('The "test" mail template does not exist with the "all" type');

        $loader = new MailLoaderChain([]);

        $loader->load('test');
    }
}
