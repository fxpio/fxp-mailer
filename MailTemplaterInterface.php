<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Interface for the mail templater.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailTemplaterInterface
{
    /**
     * Set the translator.
     *
     * @param TranslatorInterface $translator The translator
     *
     * @return static
     */
    public function setTranslator(TranslatorInterface $translator);

    /**
     * Set the locale.
     *
     * @param string $locale The locale
     *
     * @return static
     */
    public function setLocale(string $locale);

    /**
     * Get the locale.
     *
     * @return string
     */
    public function getLocale(): string;

    /**
     * Render the mail template.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     *
     * @return MailRenderedInterface
     */
    public function render(string $template, array $variables = [], string $type = MailTypes::TYPE_ALL): MailRenderedInterface;
}
