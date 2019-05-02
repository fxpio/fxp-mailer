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
 *
 * @internal
 */
final class ArrayMailLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $template = $this->getMockBuilder(MailInterface::class)->getMock();
        $template->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'))
        ;
        $template->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true))
        ;
        $template->expects($this->any())
            ->method('getType')
            ->will($this->returnValue(MailTypes::TYPE_ALL))
        ;

        $loader = new ArrayMailLoader([$template]);

        $this->assertSame($template, $loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownMailException::class);
        $this->expectExceptionMessage('The "test" mail template does not exist with the "all" type');

        $loader = new ArrayMailLoader([]);

        $loader->load('test');
    }
}
