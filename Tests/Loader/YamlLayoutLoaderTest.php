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

use PHPUnit\Framework\TestCase;
use Sonatra\Component\Mailer\Loader\YamlLayoutLoader;
use Sonatra\Component\Mailer\Model\LayoutInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tests for yaml layout loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class YamlLayoutLoaderTest extends TestCase
{
    public function testLoad()
    {
        /* @var KernelInterface|\PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $template = '@AcmeDemoBundle/Resources/loaders/layout.yml';

        $kernel->expects($this->once())
            ->method('locateResource')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/layout.yml'));

        $loader = new YamlLayoutLoader(array($template), $kernel);

        $this->assertInstanceOf(LayoutInterface::class, $loader->load('test'));
    }

    /**
     * @expectedException \Sonatra\Component\Mailer\Exception\UnknownLayoutException
     * @expectedExceptionMessage The "test" layout template does not exist
     */
    public function testLoadUnknownTemplate()
    {
        /* @var KernelInterface $kernel */
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();

        $loader = new YamlLayoutLoader(array(), $kernel);

        $loader->load('test');
    }
}
