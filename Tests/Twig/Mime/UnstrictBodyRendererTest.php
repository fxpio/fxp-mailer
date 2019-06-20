<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Twig\Mime;

use Fxp\Component\Mailer\Twig\Mime\UnstrictBodyRenderer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Mime\Message;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class UnstrictBodyRendererTest extends TestCase
{
    public function testRendererWithDisableStrictVariables(): void
    {
        /** @var BodyRendererInterface|MockObject $bodyRenderer */
        $bodyRenderer = $this->getMockBuilder(BodyRendererInterface::class)->getMock();

        /** @var LoaderInterface|MockObject $twigLoader */
        $twigLoader = $this->getMockBuilder(LoaderInterface::class)->getMock();

        $twig = new Environment($twigLoader, ['strict_variables' => true]);
        $unstrictBodyRenderer = new UnstrictBodyRenderer($bodyRenderer, $twig);
        $message = new Message();

        $disabledBeforeRenderValue = $twig->isStrictVariables();

        $bodyRenderer->expects(static::once())
            ->method('render')
            ->with($message)
            ->willReturnCallback(static function () use (&$disabledBeforeRenderValue, $twig): void {
                $disabledBeforeRenderValue = $twig->isStrictVariables();
            })
        ;

        static::assertTrue($disabledBeforeRenderValue);
        static::assertTrue($twig->isStrictVariables());

        $unstrictBodyRenderer->render($message);

        static::assertTrue($twig->isStrictVariables());
        static::assertFalse($disabledBeforeRenderValue);
    }
}
