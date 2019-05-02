<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Transport;

use Fxp\Component\Mailer\Exception\UnexpectedTypeException;
use Fxp\Component\Mailer\MailRenderedInterface;

/**
 * Interface for the transport.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TransportInterface
{
    /**
     * Get the name.
     *
     * @return string
     */
    public function getName();

    /**
     * Send a mail.
     *
     * Call the TransportInterface::validate() method.
     *
     * @param mixed                      $message      The message for the specific transport
     * @param null|MailRenderedInterface $mailRendered The rendered mail
     *
     * @throws UnexpectedTypeException When the instance of message isn't valid for this transport
     *
     * @return bool
     */
    public function send($message, MailRenderedInterface $mailRendered = null);

    /**
     * Validate the message.
     *
     * @param mixed $message The message for the specific transport
     *
     * @throws UnexpectedTypeException When the instance of message isn't valid for this transport
     */
    public function validate($message);
}
