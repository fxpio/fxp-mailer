<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Twig\Loader;

use Fxp\Component\Mailer\Mime\SandboxTemplaterInterface;
use Fxp\Component\Mailer\Twig\Loader\SandboxLoader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;
use Twig\Source;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SandboxLoaderTest extends TestCase
{
    /**
     * @var MockObject|SandboxTemplaterInterface
     */
    protected $sandboxTemplater;

    /**
     * @var SandboxLoader
     */
    protected $loader;

    protected function setUp(): void
    {
        $this->sandboxTemplater = $this->getMockBuilder(SandboxTemplaterInterface::class)->getMock();
        $this->loader = new SandboxLoader($this->sandboxTemplater, ['test_namespace']);
    }

    protected function tearDown(): void
    {
        $this->sandboxTemplater = null;
        $this->loader = null;
    }

    /**
     * @throws
     */
    public function testGetSourceContext(): void
    {
        $this->assertEquals(new Source('', 'name'), $this->loader->getSourceContext('name'));
    }

    /**
     * @throws
     */
    public function testGetCacheKey(): void
    {
        $this->assertSame('name', $this->loader->getCacheKey('name'));
    }

    /**
     * @throws
     */
    public function testIsFresh(): void
    {
        $this->assertFalse($this->loader->isFresh('name', 0));
    }

    /**
     * @throws
     */
    public function testExistsWithoutSandbox(): void
    {
        $this->sandboxTemplater->expects($this->once())
            ->method('isSandboxed')
            ->willReturn(false)
        ;

        $this->assertFalse($this->loader->exists('name'));
    }

    /**
     * @throws
     */
    public function testExistsWithSandboxAndValidNamespace(): void
    {
        $this->sandboxTemplater->expects($this->once())
            ->method('isSandboxed')
            ->willReturn(true)
        ;

        $this->assertFalse($this->loader->exists('@test_namespace/name'));
    }

    /**
     * @throws
     */
    public function testExistsWithSandboxAndInvalidNamespace(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Unable to find template "@invalid_namespace/name".');

        $this->sandboxTemplater->expects($this->once())
            ->method('isSandboxed')
            ->willReturn(true)
        ;

        $this->loader->exists('@invalid_namespace/name');
    }

    /**
     * @throws
     */
    public function testExistsWithSandboxAndInvalidNamespaceWithoutName(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Unable to find template "@invalid_namespace_without_name".');

        $this->sandboxTemplater->expects($this->once())
            ->method('isSandboxed')
            ->willReturn(true)
        ;

        $this->loader->exists('@invalid_namespace_without_name');
    }

    /**
     * @throws
     */
    public function testExistsWithSandboxAndWithoutNamespace(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Unable to find template "name".');

        $this->sandboxTemplater->expects($this->once())
            ->method('isSandboxed')
            ->willReturn(true)
        ;

        $this->loader->exists('name');
    }
}
