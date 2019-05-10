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

use Doctrine\Common\Collections\Collection;

/**
 * Interface for the mail template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailInterface extends TemplateInterface
{
    /**
     * Set the mail type.
     *
     * @param string $type The mail type
     *
     * @return static
     */
    public function setType(string $type);

    /**
     * Get the mail type.
     *
     * @return string
     */
    public function getType(): string;

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

    /**
     * Set the layout.
     *
     * @param LayoutInterface $layout The layout
     *
     * @return static
     */
    public function setLayout(?LayoutInterface $layout);

    /**
     * Get the layout.
     *
     * @return null|LayoutInterface
     */
    public function getLayout(): ?LayoutInterface;

    /**
     * Get the mail translations.
     *
     * @return array|Collection|MailTranslationInterface[]
     */
    public function getTranslations();

    /**
     * Add a mail translation.
     *
     * @param MailTranslationInterface $translation The mail translation
     *
     * @return static
     */
    public function addTranslation(MailTranslationInterface $translation);

    /**
     * Remove a mail translation.
     *
     * @param MailTranslationInterface $translation The mail translation
     *
     * @return static
     */
    public function removeTranslation(MailTranslationInterface $translation);

    /**
     * Get the translated mail.
     *
     * @param string $locale The locale
     *
     * @return static
     */
    public function getTranslation(string $locale);
}
