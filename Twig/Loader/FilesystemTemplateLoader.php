<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Twig\Loader;

use Symfony\Component\Intl\Locales;
use Twig\Error\LoaderError;
use Twig\Loader\FilesystemLoader;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilesystemTemplateLoader extends FilesystemLoader
{
    /**
     * @var string
     */
    private $fallback;

    /**
     * Constructor.
     *
     * @param null|string $rootPath
     * @param string      $fallback
     * @param string      $path
     * @param string      $namespace
     *
     * @throws \Twig\Error\LoaderError
     */
    public function __construct(
        string $rootPath = null,
        string $fallback = 'en',
        string $path = 'templates',
        string $namespace = 'templates'
    ) {
        parent::__construct([], $rootPath);

        $this->fallback = $fallback;
        $this->addPath($path, $namespace);
    }

    /**
     * {@inheritdoc}
     *
     * @throws
     */
    protected function findTemplate($name, $throw = true)
    {
        if (0 !== strpos($name, '@'.$this->getNamespaces()[0])) {
            return null;
        }

        list($templateName) = $this->getLocalizedTemplate($name);

        foreach ([null, $this->fallback] as $locale) {
            $template = $this->findLocalizedTemplate($templateName, $locale, null !== $locale);

            if (\is_string($template)) {
                return $template;
            }
        }

        if ($throw) {
            throw new LoaderError($this->errorCache[$templateName]);
        }

        return null;
    }

    /**
     * Find the localized template.
     *
     * @param string      $name    The template name
     * @param null|string $locale  The locale
     * @param bool        $replace Check if the locale in template name must be replaced
     *
     * @throws LoaderError
     *
     * @return null|string
     */
    private function findLocalizedTemplate(string $name, ?string $locale, bool $replace = false): ?string
    {
        list($templateName, $locale) = $this->getLocalizedTemplate($name, $locale, $replace);
        $template = parent::findTemplate($templateName, false);

        if (!\is_string($template) && false !== strpos($locale, '_')) {
            $locale = explode('_', $locale)[0];
            list($templateName) = $this->getLocalizedTemplate($name, $locale, true);
            $template = parent::findTemplate($templateName, false);

            if (\is_string($template)) {
                return $template;
            }
        }

        return false === $template ? null : $template;
    }

    /**
     * Get the localized template.
     *
     * @param string      $name      The template name
     * @param null|string $newLocale The new locale
     * @param bool        $replace   Check if the new locale must replace the template locale if it exists
     *
     * @return string[]
     */
    private function getLocalizedTemplate(string $name, ?string $newLocale = null, bool $replace = false): array
    {
        $basedir = \dirname($name);
        $names = explode('.', basename($name));
        $locale = $names[0];
        $localePosition = \count($names) - 1;

        if ('twig' === strtolower($names[\count($names) - 1])) {
            $localePosition = max(0, \count($names) - 3);
            $locale = $names[$localePosition];
        }

        if (!Locales::exists($locale)) {
            $locale = $newLocale ?? \Locale::getDefault();
            array_splice($names, 1, 0, [$locale]);
        } elseif ($replace && null !== $newLocale) {
            $names[$localePosition] = $newLocale;
            $locale = $newLocale;
        }

        return [$basedir.'/'.implode('.', $names), $locale];
    }
}
