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
 */
class MailLoaderChainTest extends TestCase
{
    public function testLoad()
    {
        $template = $this->getMockBuilder(MailInterface::class)->getMock();

        $loader1 = $this->getMockBuilder(MailLoaderInterface::class)->getMock();
        $loader1->expects($this->once())
            ->method('load')
            ->willThrowException(new UnknownMailException('test', MailTypes::TYPE_ALL));

        $loader2 = $this->getMockBuilder(MailLoaderInterface::class)->getMock();
        $loader2->expects($this->once())
            ->method('load')
            ->will($this->returnValue($template));

        $chainLoader = new MailLoaderChain(array($loader1, $loader2));

        $this->assertSame($template, $chainLoader->load('test'));
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\UnknownMailException
     * @expectedExceptionMessage The "test" mail template does not exist with the "all" type
     */
    public function testLoadUnknownTemplate()
    {
        $loader = new MailLoaderChain(array());

        $loader->load('test');
    }
}
