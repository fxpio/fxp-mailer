<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer;

use Fxp\Component\Mailer\Exception\TransporterNotFoundException;
use Symfony\Component\Mime\RawMessage;

/**
 * Interface for the mailer.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailerInterface
{
    /**
     * Send the message.
     *
     * @param RawMessage  $message  The message
     * @param null|object $envelope The envelope
     *
     * @throws TransporterNotFoundException
     */
    public function send(RawMessage $message, $envelope = null): void;

    /**
     * Check if the from is required.
     *
     * @param RawMessage  $message  The message
     * @param null|object $envelope The envelope
     *
     * @throws TransporterNotFoundException
     *
     * @return bool
     */
    public function hasRequiredFrom(RawMessage $message, $envelope = null): bool;
}
