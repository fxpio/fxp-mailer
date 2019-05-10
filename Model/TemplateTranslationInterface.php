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
 * Base interface for the template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateTranslationInterface
{
    /**
     * Set the locale.
     *
     * @param null|string $locale The locale
     *
     * @return static
     */
    public function setLocale(?string $locale);

    /**
     * Get the locale.
     *
     * @return string
     */
    public function getLocale(): ?string;

    /**
     * Set the label.
     *
     * @param null|string $label The label
     *
     * @return static
     */
    public function setLabel(?string $label);

    /**
     * Get the label.
     *
     * @return null|string
     */
    public function getLabel(): ?string;

    /**
     * Set the description.
     *
     * @param null|string $description The description
     *
     * @return static
     */
    public function setDescription(?string $description);

    /**
     * Get the description.
     *
     * @return null|string
     */
    public function getDescription(): ?string;

    /**
     * Set the body.
     *
     * @param null|string $body The body
     *
     * @return static
     */
    public function setBody(?string $body);

    /**
     * Get the body.
     *
     * @return null|string
     */
    public function getBody(): ?string;
}
