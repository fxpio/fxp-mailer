<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Model\Traits;

use Sonatra\Component\Mailer\Util\TranslationUtil;

/**
 * Trait for translation model.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
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

        /* @var \Sonatra\Component\Mailer\Model\LayoutInterface|\Sonatra\Component\Mailer\Model\MailInterface|TranslationTrait $this */
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
