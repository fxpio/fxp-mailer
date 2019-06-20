<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Twig\Mime;

use Fxp\Component\Mailer\Mime\SandboxInterface;
use Fxp\Component\SmsSender\Twig\Mime\TemplatedSms;

/**
 * Templated sms to enable the sandbox.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class SandboxTemplatedSms extends TemplatedSms implements SandboxInterface
{
}
