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

use Fxp\Component\Mailer\Loader\ArrayLayoutLoader;
use Fxp\Component\Mailer\Model\LayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for Array layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ArrayLayoutLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $template = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $template->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'))
        ;
        $template->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true))
        ;

        $loader = new ArrayLayoutLoader([$template]);

        $this->assertSame($template, $loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        $loader = new ArrayLayoutLoader([]);

        $loader->load('test');
    }
}
