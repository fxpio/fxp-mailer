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
use Fxp\Component\Mailer\Model\Traits\TemplateTranslationTrait;

/**
 * Model for layout template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TemplateLayout extends AbstractTemplate implements TemplateLayoutInterface
{
    use TemplateTranslationTrait;

    /**
     * @var Collection|TemplateMailInterface[]
     */
    protected $mails = [];

    /**
     * @var Collection|TemplateLayoutTranslationInterface[]
     */
    protected $translations = [];

    /**
     * {@inheritdoc}
     */
    public function getMails()
    {
        return $this->mails;
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
    public function addTranslation(TemplateLayoutTranslationInterface $translation): self
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
    public function removeTranslation(TemplateLayoutTranslationInterface $translation): self
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
