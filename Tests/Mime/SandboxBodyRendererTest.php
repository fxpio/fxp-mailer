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

use Fxp\Component\Mailer\Mime\SandboxBodyRenderer;
use Fxp\Component\Mailer\Mime\SandboxTemplaterInterface;
use Fxp\Component\Mailer\Tests\Fixtures\Mock\SandboxMessage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\BodyRendererInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SandboxBodyRendererTest extends TestCase
{
    public function testRenderWithSandboxTemplater(): void
    {
        /** @var BodyRendererInterface|MockObject $innerBodyRenderer */
        $innerBodyRenderer = $this->getMockBuilder(BodyRendererInterface::class)->getMock();

        /** @var MockObject|SandboxTemplaterInterface $sandboxTemplater */
        $sandboxTemplater = $this->getMockBuilder(SandboxTemplaterInterface::class)->getMock();

        $sandboxBodyRenderer = new SandboxBodyRenderer($innerBodyRenderer, $sandboxTemplater);
        $message = new SandboxMessage();

        $sandboxTemplater->expects(static::once())
            ->method('isSandboxed')
            ->willReturn(false)
        ;

        $sandboxTemplater->expects(static::once())
            ->method('enableSandbox')
        ;

        $sandboxTemplater->expects(static::once())
            ->method('disableSandbox')
        ;

        $innerBodyRenderer->expects(static::once())
            ->method('render')
            ->with($message)
        ;

        $sandboxBodyRenderer->render($message);
    }
}
