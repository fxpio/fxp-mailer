<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Model;

/**
 * Interface for the mail template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailTranslationInterface extends TemplateTranslationInterface
{
    /**
     * Get the reference mail.
     *
     * @return MailInterface
     */
    public function getMail();

    /**
     * Set the subject.
     *
     * @param null|string $subject The subject
     *
     * @return self
     */
    public function setSubject($subject);

    /**
     * Get the subject.
     *
     * @return null|string
     */
    public function getSubject();

    /**
     * Set the html body.
     *
     * @param null|string $htmlBody The html body
     *
     * @return self
     */
    public function setHtmlBody($htmlBody);

    /**
     * Get the html body.
     *
     * @return null|string
     */
    public function getHtmlBody();
}
