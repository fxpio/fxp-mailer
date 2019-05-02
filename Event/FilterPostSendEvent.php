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
 * Class event for the transport.post_send event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterPostSendEvent extends AbstractFilterSendEvent
{
    /**
     * @var bool
     */
    protected $result;

    /**
     * Constructor.
     *
     * @param bool                       $result       The send result
     * @param string                     $transport    The name of transport
     * @param mixed                      $message      The message for the specific transport
     * @param null|MailRenderedInterface $mailRendered The mail rendered
     */
    public function __construct($result, $transport, $message, MailRenderedInterface $mailRendered = null)
    {
        parent::__construct($transport, $message, $mailRendered);

        $this->result = $result;
    }

    /**
     * Check if the message was sent with successfully.
     *
     * @return bool
     */
    public function isSend()
    {
        return $this->result;
    }
}
