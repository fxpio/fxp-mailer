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
 * Template message interface.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateMessageInterface
{
    /**
     * Get the id of model.
     *
     * @return null|int|string
     */
    public function getId();

    /**
     * Sets the unique template name.
     *
     * @param null|string $name The name
     *
     * @return static
     */
    public function setName(?string $name);

    /**
     * Gets the unique template name.
     *
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * Set the type.
     *
     * @param null|string $type The type
     *
     * @return static
     */
    public function setType(?string $type);

    /**
     * Get the type.
     *
     * @return null|string
     */
    public function getType(): ?string;

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
     * Set if the template is enabled.
     *
     * @param bool $enabled The enabled value
     *
     * @return static
     */
    public function setEnabled(bool $enabled);

    /**
     * Check if the template is enabled.
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
     * Set the date of update of model.
     *
     * @param null|\DateTime $createdAt The created datetime
     *
     * @return static
     */
    public function setCreatedAt(?\DateTime $createdAt);

    /**
     * Get the date of create of model.
     *
     * @return null|\DateTime
     */
    public function getCreatedAt(): ?\DateTime;

    /**
     * Set the date of update of model.
     *
     * @param null|\DateTime $updatedAt The updated datetime
     *
     * @return static
     */
    public function setUpdatedAt(?\DateTime $updatedAt);

    /**
     * Get the date of update of model.
     *
     * @return null|\DateTime
     */
    public function getUpdatedAt(): ?\DateTime;
}
