<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Filter;

use Fxp\Component\Mailer\MailRenderedInterface;

/**
 * Interface for the transport filter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TransportFilterInterface
{
    /**
     * Filter the mail rendered.
     *
     * @param string                     $transport    The name of transport
     * @param mixed                      $message      The message for the specific transport
     * @param null|MailRenderedInterface $mailRendered The mail rendered
     */
    public function filter(string $transport, $message, ?MailRenderedInterface $mailRendered = null): void;

    /**
     * Check if the filter is compatible with the mail rendered.
     *
     * @param string                     $transport    The name of transport
     * @param mixed                      $message      The message for the specific transport
     * @param null|MailRenderedInterface $mailRendered The mail rendered
     *
     * @return bool
     */
    public function supports(string $transport, $message, ?MailRenderedInterface $mailRendered = null): bool;
}
