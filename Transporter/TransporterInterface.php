<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Transporter;

use Fxp\Component\Mailer\Exception\TransporterExceptionInterface;
use Symfony\Component\Mime\RawMessage;

/**
 * Interface for the transporter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TransporterInterface
{
    /**
     * Check if the transporter supports the message.
     *
     * @param RawMessage  $message  The message
     * @param null|object $envelope The envelope
     *
     * @return bool
     */
    public function supports(RawMessage $message, $envelope = null): bool;

    /**
     * Send the message.
     *
     * @param RawMessage  $message  The message
     * @param null|object $envelope The envelope
     *
     * @throws TransporterExceptionInterface
     */
    public function send(RawMessage $message, $envelope = null): void;
}
