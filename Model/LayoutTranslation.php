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
 * Model for layout translation template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class LayoutTranslation implements LayoutTranslationInterface
{
    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var null|string
     */
    protected $label;

    /**
     * @var null|string
     */
    protected $description;

    /**
     * @var null|string
     */
    protected $body;

    /**
     * Constructor.
     *
     * @param LayoutInterface $layout The layout
     */
    public function __construct(LayoutInterface $layout)
    {
        $layout->addTranslation($this);
        $this->layout = $layout;
    }

    /**
     * {@inheritdoc}
     */
    public function getLayout(): LayoutInterface
    {
        return $this->layout;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): ?string
    {
        return $this->body;
    }
}
