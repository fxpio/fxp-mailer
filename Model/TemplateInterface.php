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
interface TemplateInterface
{
    /**
     * Sets the unique template name.
     *
     * @param string $name The name
     *
     * @return static
     */
    public function setName(string $name);

    /**
     * Gets the unique template name.
     *
     * @return string
     */
    public function getName(): string;

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
     * Set if the model is enabled.
     *
     * @param bool $enabled The enabled value
     *
     * @return static
     */
    public function setEnabled(bool $enabled);

    /**
     * Check if the model is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool;

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

    /**
     * Set the translation domain to use the translator.
     *
     * @param null|string $domain The translation domain
     *
     * @return static
     */
    public function setTranslationDomain(?string $domain);

    /**
     * Get the translation domain to use the translator.
     *
     * @return null|string
     */
    public function getTranslationDomain(): ?string;
}
