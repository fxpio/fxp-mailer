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
 * Model for mail translation template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TemplateMailTranslation implements TemplateMailTranslationInterface
{
    /**
     * @var TemplateMailInterface
     */
    protected $mail;

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
    protected $subject;

    /**
     * @var null|string
     */
    protected $htmlBody;

    /**
     * @var null|string
     */
    protected $body;

    /**
     * Constructor.
     *
     * @param TemplateMailInterface $mail The mail
     */
    public function __construct(TemplateMailInterface $mail)
    {
        $mail->addTranslation($this);
        $this->mail = $mail;
    }

    /**
     * {@inheritdoc}
     */
    public function getMail(): TemplateMailInterface
    {
        return $this->mail;
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
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setHtmlBody(?string $htmlBody): self
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlBody(): ?string
    {
        return $this->htmlBody;
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
