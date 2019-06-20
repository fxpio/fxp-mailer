<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Mime;

use Fxp\Component\Mailer\Mime\SandboxTemplater;
use PHPUnit\Framework\TestCase;
use Twig\Extension\SandboxExtension;
use Twig\Sandbox\SecurityPolicyInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SandboxTemplaterTest extends TestCase
{
    public function testDefault(): void
    {
        $sandbox = new SandboxTemplater();

        static::assertFalse($sandbox->isSandboxed());

        $sandbox->enableSandbox();
        static::assertTrue($sandbox->isSandboxed());

        $sandbox->disableSandbox();
        static::assertFalse($sandbox->isSandboxed());
    }

    public function testWithSandboxExtension(): void
    {
        /** @var SecurityPolicyInterface $policy */
        $policy = $this->getMockBuilder(SecurityPolicyInterface::class)->getMock();
        $ext = new SandboxExtension($policy);

        $sandbox = new SandboxTemplater($ext);

        static::assertFalse($sandbox->isSandboxed());
        static::assertFalse($ext->isSandboxed());

        $sandbox->enableSandbox();
        static::assertTrue($sandbox->isSandboxed());
        static::assertTrue($ext->isSandboxed());

        $sandbox->disableSandbox();
        static::assertFalse($sandbox->isSandboxed());
        static::assertFalse($ext->isSandboxed());
    }
}
