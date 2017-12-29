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

/**
 * Class event for the transport.pre_send event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterPreSendEvent extends AbstractFilterSendEvent
{
    /**
     * Set the name of transport.
     *
     * @param string $transport The name of transport
     *
     * @return self
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Set the message for the specific transport.
     *
     * @param mixed $message The message for the specific transport
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the mail rendered.
     *
     * @param MailRenderedInterface|null $mailRendered The mail rendered
     *
     * @return self
     */
    public function setMailRendered(MailRenderedInterface $mailRendered = null)
    {
        $this->mailRendered = $mailRendered;

        return $this;
    }
}
