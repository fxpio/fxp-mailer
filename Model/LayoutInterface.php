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
interface LayoutInterface extends TemplateInterface
{
    /**
     * @return array|Collection|MailInterface[]
     */
    public function getMails();

    /**
     * Get the layout translations.
     *
     * @return array|Collection|LayoutTranslationInterface[]
     */
    public function getTranslations();

    /**
     * Add a layout translation.
     *
     * @param LayoutTranslationInterface $translation The layout translation
     *
     * @return static
     */
    public function addTranslation(LayoutTranslationInterface $translation);

    /**
     * Remove a layout translation.
     *
     * @param LayoutTranslationInterface $translation The layout translation
     *
     * @return static
     */
    public function removeTranslation(LayoutTranslationInterface $translation);

    /**
     * Get the translated layout.
     *
     * @param string $locale The locale
     *
     * @return static
     */
    public function getTranslation(string $locale);
}
