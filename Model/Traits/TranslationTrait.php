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

use Fxp\Component\Mailer\Util\TranslationUtil;

/**
 * Trait for translation model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
trait TranslationTrait
{
    /**
     * @var array
     */
    protected $cacheTranslation = array();

    /**
     * @var string|null
     */
    protected $translationDomain;

    /**
     * {@inheritdoc}
     */
    public function getTranslation($locale)
    {
        $locale = strtolower($locale);

        if (isset($this->cacheTranslation[$locale])) {
            return $this->cacheTranslation[$locale];
        }

        /* @var \Fxp\Component\Mailer\Model\LayoutInterface|\Fxp\Component\Mailer\Model\MailInterface|TranslationTrait $this */
        $self = clone $this;

        if (!TranslationUtil::find($self, $locale) && false !== ($pos = strrpos($locale, '_'))) {
            TranslationUtil::find($self, substr($locale, 0, $pos));
        }

        $this->cacheTranslation[$locale] = $self;

        return $self;
    }

    /**
     * {@inheritdoc}
     */
    public function setTranslationDomain($domain)
    {
        $this->translationDomain = $domain;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTranslationDomain()
    {
        return $this->translationDomain;
    }
}
