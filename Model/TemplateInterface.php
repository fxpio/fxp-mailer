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
     * @return self
     */
    public function setName($name);

    /**
     * Gets the unique template name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set the label.
     *
     * @param null|string $label The label
     *
     * @return self
     */
    public function setLabel($label);

    /**
     * Get the label.
     *
     * @return null|string
     */
    public function getLabel();

    /**
     * Set the description.
     *
     * @param null|string $description The description
     *
     * @return self
     */
    public function setDescription($description);

    /**
     * Get the description.
     *
     * @return null|string
     */
    public function getDescription();

    /**
     * Set if the model is enabled.
     *
     * @param bool $enabled The enabled value
     *
     * @return self
     */
    public function setEnabled($enabled);

    /**
     * Check if the model is enabled.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Set the body.
     *
     * @param null|string $body The body
     *
     * @return self
     */
    public function setBody($body);

    /**
     * Get the body.
     *
     * @return null|string
     */
    public function getBody();

    /**
     * Set the translation domain to use the translator.
     *
     * @param null|string $domain The translation domain
     *
     * @return self
     */
    public function setTranslationDomain($domain);

    /**
     * Get the translation domain to use the translator.
     *
     * @return null|string
     */
    public function getTranslationDomain();
}
