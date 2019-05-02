<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Event;

use Fxp\Component\Mailer\MailRenderedInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Base class event for the transport.* event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractFilterSendEvent extends Event
{
    /**
     * @var string
     */
    protected $transport;

    /**
     * @var mixed
     */
    protected $message;

    /**
     * @var null|MailRenderedInterface
     */
    protected $mailRendered;

    /**
     * Constructor.
     *
     * @param string                     $transport    The name of transport
     * @param mixed                      $message      The message for the specific transport
     * @param null|MailRenderedInterface $mailRendered The mail rendered
     */
    public function __construct($transport, $message, MailRenderedInterface $mailRendered = null)
    {
        $this->transport = $transport;
        $this->message = $message;
        $this->mailRendered = $mailRendered;
    }

    /**
     * Get the name of transport.
     *
     * @return string
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Get the message for the specific transport.
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the mail rendered.
     *
     * @return null|MailRenderedInterface
     */
    public function getMailRendered()
    {
        return $this->mailRendered;
    }
}
