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

use Fxp\Component\Mailer\Twig\Mime\SandboxTemplatedSms;
use Fxp\Component\SmsSender\Twig\Mime\TemplatedSms;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SandboxTemplatedSmsTest extends TestCase
{
    public function testConstructor(): void
    {
        static::assertInstanceOf(TemplatedSms::class, new SandboxTemplatedSms());
    }
}
