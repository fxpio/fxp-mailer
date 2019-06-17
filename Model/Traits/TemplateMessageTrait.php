<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use Fxp\Component\Mailer\Model\TemplateMessageInterface;

/**
 * Template message trait.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
trait TemplateMessageTrait
{
    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=10)
     */
    protected $type;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $label;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $description;

    /**
     * @var null|string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $body;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var null|\DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setName()
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getName()
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setType()
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getType()
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setLabel()
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getLabel()
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setDescription()
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getDescription()
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setBody()
     */
    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getBody()
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setCreatedAt()
     */
    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getCreatedAt()
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::setUpdatedAt()
     */
    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see TemplateMessageInterface::getUpdatedAt()
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
