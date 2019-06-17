<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Fixtures\Mock;

use Fxp\Component\Mailer\Mime\SandboxInterface;
use Symfony\Component\Mime\Message;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class SandboxMessage extends Message implements SandboxInterface
{
}
