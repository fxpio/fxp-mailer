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
 * Interface for the template filter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateFilterInterface
{
    /**
     * Filter the mail rendered.
     *
     * @param MailRenderedInterface $mailRendered The mail rendered
     */
    public function filter(MailRenderedInterface $mailRendered);

    /**
     * Check if the filter is compatible with the mail rendered.
     *
     * @param MailRenderedInterface $mailRendered The mail rendered
     *
     * @return bool
     */
    public function supports(MailRenderedInterface $mailRendered);
}
