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
 * Interface for the layout template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface LayoutInterface extends TemplateInterface
{
    /**
     * @return \Doctrine\Common\Collections\Collection|MailInterface[]
     */
    public function getMails();

    /**
     * Get the layout translations.
     *
     * @return \Doctrine\Common\Collections\Collection|LayoutTranslationInterface[]
     */
    public function getTranslations();

    /**
     * Add a layout translation.
     *
     * @param LayoutTranslationInterface $translation The layout translation
     *
     * @return self
     */
    public function addTranslation(LayoutTranslationInterface $translation);

    /**
     * Remove a layout translation.
     *
     * @param LayoutTranslationInterface $translation The layout translation
     *
     * @return self
     */
    public function removeTranslation(LayoutTranslationInterface $translation);

    /**
     * Get the translated layout.
     *
     * @param string $locale The locale
     *
     * @return self
     */
    public function getTranslation($locale);
}
