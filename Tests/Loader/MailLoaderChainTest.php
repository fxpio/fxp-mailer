<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Tests\Loader;

use Sonatra\Component\Mailer\Exception\UnknownMailException;
use Sonatra\Component\Mailer\Loader\MailLoaderChain;
use Sonatra\Component\Mailer\Loader\MailLoaderInterface;
use Sonatra\Component\Mailer\MailTypes;
use Sonatra\Component\Mailer\Model\MailInterface;

/**
 * Tests for chain layout loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class MailLoaderChainTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException \Sonatra\Component\Mailer\Exception\UnknownMailException
     * @expectedExceptionMessage The "test" mail template does not exist with the "all" type
     */
    public function testLoadUnknownTemplate()
    {
        $loader = new MailLoaderChain(array());

        $loader->load('test');
    }
}
