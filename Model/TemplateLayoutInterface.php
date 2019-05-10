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

/**
 * Interface for the layout template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateLayoutInterface extends TemplateInterface
{
    /**
     * @return array|Collection|TemplateMailInterface[]
     */
    public function getMails();

    /**
     * Get the layout translations.
     *
     * @return array|Collection|TemplateLayoutTranslationInterface[]
     */
    public function getTranslations();

    /**
     * Add a layout translation.
     *
     * @param TemplateLayoutTranslationInterface $translation The layout translation
     *
     * @return static
     */
    public function addTranslation(TemplateLayoutTranslationInterface $translation);

    /**
     * Remove a layout translation.
     *
     * @param TemplateLayoutTranslationInterface $translation The layout translation
     *
     * @return static
     */
    public function removeTranslation(TemplateLayoutTranslationInterface $translation);

    /**
     * Get the translated layout.
     *
     * @param string $locale The locale
     *
     * @return static
     */
    public function getTranslation(string $locale);
}
