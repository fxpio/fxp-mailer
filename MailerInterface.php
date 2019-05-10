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

use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Transport\TransportInterface;

/**
 * Interface for the mailer.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailerInterface
{
    /**
     * Add a mail transport.
     *
     * @param TransportInterface $transport The mail transport
     *
     * @return static
     */
    public function addTransport(TransportInterface $transport);

    /**
     * Check if the mail transport is present.
     *
     * @param string $name The name of the mail transport
     *
     * @return bool
     */
    public function hasTransport(string $name): bool;

    /**
     * Get the mail transport.
     *
     * @param string $name The name of the mail transport
     *
     * @throws InvalidArgumentException When the transport does not exist
     *
     * @return TransportInterface
     */
    public function getTransport(string $name): TransportInterface;

    /**
     * Send the message with a specific transport.
     *
     * @param string      $transport The name of transport
     * @param mixed       $message   The message for the specific transport
     * @param null|string $template  The mail template name
     * @param array       $variables The variables of template
     * @param string      $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return bool
     */
    public function send(string $transport, $message, ?string $template = null, array $variables = [], string $type = MailTypes::TYPE_ALL): bool;
}
