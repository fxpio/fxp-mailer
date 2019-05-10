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
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\Traits\TranslationTrait;

/**
 * Model for mail template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class Mail extends AbstractTemplate implements MailInterface
{
    use TranslationTrait;

    /**
     * @var string
     */
    protected $type = MailTypes::TYPE_ALL;

    /**
     * @var null|string
     */
    protected $subject;

    /**
     * @var null|string
     */
    protected $htmlBody;

    /**
     * @var null|LayoutInterface
     */
    protected $layout;

    /**
     * @var Collection|MailTranslationInterface[]
     */
    protected $translations = [];

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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
    public function setLayout(?LayoutInterface $layout): self
    {
        $this->layout = $layout;

        return $this;
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
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * {@inheritdoc}
     */
    public function addTranslation(MailTranslationInterface $translation): self
    {
        if ($this->translations instanceof Collection) {
            if (!$this->translations->contains($translation)) {
                $this->translations->add($translation);
            }
        } else {
            $this->translations[$translation->getLocale()] = $translation;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTranslation(MailTranslationInterface $translation): self
    {
        if ($this->translations instanceof Collection) {
            if ($this->translations->contains($translation)) {
                $this->translations->removeElement($translation);
            }
        } else {
            unset($this->translations[$translation->getLocale()]);
        }

        return $this;
    }
}
