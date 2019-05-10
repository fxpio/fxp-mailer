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
interface TemplateMailInterface extends TemplateInterface
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
     * @param TemplateLayoutInterface $layout The layout
     *
     * @return static
     */
    public function setLayout(?TemplateLayoutInterface $layout);

    /**
     * Get the layout.
     *
     * @return null|TemplateLayoutInterface
     */
    public function getLayout(): ?TemplateLayoutInterface;

    /**
     * Get the mail translations.
     *
     * @return array|Collection|TemplateMailTranslationInterface[]
     */
    public function getTranslations();

    /**
     * Add a mail translation.
     *
     * @param TemplateMailTranslationInterface $translation The mail translation
     *
     * @return static
     */
    public function addTranslation(TemplateMailTranslationInterface $translation);

    /**
     * Remove a mail translation.
     *
     * @param TemplateMailTranslationInterface $translation The mail translation
     *
     * @return static
     */
    public function removeTranslation(TemplateMailTranslationInterface $translation);

    /**
     * Get the translated mail.
     *
     * @param string $locale The locale
     *
     * @return static
     */
    public function getTranslation(string $locale);
}
