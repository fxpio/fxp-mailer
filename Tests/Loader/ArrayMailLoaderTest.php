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

use Fxp\Component\Mailer\Loader\ArrayMailLoader;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Array mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ArrayMailLoaderTest extends TestCase
{
    public function testLoad()
    {
        $template = $this->getMockBuilder(MailInterface::class)->getMock();
        $template->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'));
        $template->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true));
        $template->expects($this->any())
            ->method('getType')
            ->will($this->returnValue(MailTypes::TYPE_ALL));

        $loader = new ArrayMailLoader(array($template));

        $this->assertSame($template, $loader->load('test'));
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\UnknownMailException
     * @expectedExceptionMessage The "test" mail template does not exist with the "all" type
     */
    public function testLoadUnknownTemplate()
    {
        $loader = new ArrayMailLoader(array());

        $loader->load('test');
    }
}
