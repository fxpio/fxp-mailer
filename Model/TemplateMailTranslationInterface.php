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
interface TemplateMailTranslationInterface extends TemplateTranslationInterface
{
    /**
     * Get the reference mail.
     *
     * @return TemplateMailInterface
     */
    public function getMail(): TemplateMailInterface;

    /**
     * Set the subject.
     *
     * @param null|string $subject The subject
     *
     * @return static
     */
    public function setSubject(?string $subject);

    /**
     * Get the subject.
     *
     * @return null|string
     */
    public function getSubject(): ?string;

    /**
     * Set the html body.
     *
     * @param null|string $htmlBody The html body
     *
     * @return static
     */
    public function setHtmlBody(?string $htmlBody);

    /**
     * Get the html body.
     *
     * @return null|string
     */
    public function getHtmlBody(): ?string;
}
