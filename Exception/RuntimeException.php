<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\MailerBundle\Exception;

/**
 * Base RuntimeException for the Mailer component.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
}
