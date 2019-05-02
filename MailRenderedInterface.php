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

use Fxp\Component\Mailer\Model\MailInterface;

/**
 * Interface for the mail rendered.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailRenderedInterface
{
    /**
     * Get the mail template.
     *
     * @return MailInterface
     */
    public function getTemplate();

    /**
     * Set the rendered subject.
     *
     * @param null|string $subject The rendered subject
     *
     * @return self
     */
    public function setSubject($subject);

    /**
     * Get the rendered subject.
     *
     * @return null|string
     */
    public function getSubject();

    /**
     * Set the rendered HTML body.
     *
     * @param null|string $htmlBody The rendered HTML body
     *
     * @return self
     */
    public function setHtmlBody($htmlBody);

    /**
     * Get the rendered HTML body.
     *
     * @return null|string
     */
    public function getHtmlBody();

    /**
     * Set the rendered body.
     *
     * @param null|string $body The rendered body
     *
     * @return self
     */
    public function setBody($body);

    /**
     * Get the rendered body.
     *
     * @return null|string
     */
    public function getBody();
}
