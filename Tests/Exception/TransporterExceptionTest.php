<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Exception;

use Fxp\Component\Mailer\Exception\TransporterException;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TransporterExceptionTest extends TestCase
{
    public function testException(): void
    {
        $e = new TransporterException('MESSAGE');

        static::assertSame('MESSAGE', $e->getMessage());
    }
}
