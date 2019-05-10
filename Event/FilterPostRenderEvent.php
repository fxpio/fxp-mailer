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
 * Class event for the template.post_render event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterPostRenderEvent extends Event
{
    /**
     * @var MailRenderedInterface
     */
    protected $mailRendered;

    /**
     * Constructor.
     *
     * @param MailRenderedInterface $mailRendered The mail rendered
     */
    public function __construct(MailRenderedInterface $mailRendered)
    {
        $this->mailRendered = $mailRendered;
    }

    /**
     * Get the mail rendered.
     *
     * @return MailRenderedInterface
     */
    public function getMailRendered(): MailRenderedInterface
    {
        return $this->mailRendered;
    }
}
