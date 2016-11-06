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

use Sonatra\Component\Mailer\Loader\ArrayLayoutLoader;
use Sonatra\Component\Mailer\Model\LayoutInterface;

/**
 * Tests for Array layout loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ArrayLayoutLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $template = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $template->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'));
        $template->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        $loader = new ArrayLayoutLoader(array($template));

        $this->assertSame($template, $loader->load('test'));
    }

    /**
     * @expectedException \Sonatra\Component\Mailer\Exception\UnknownLayoutException
     * @expectedExceptionMessage The "test" layout template does not exist
     */
    public function testLoadUnknownTemplate()
    {
        $loader = new ArrayLayoutLoader(array());

        $loader->load('test');
    }
}
