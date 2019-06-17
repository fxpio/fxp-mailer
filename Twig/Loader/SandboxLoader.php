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

use Fxp\Component\Mailer\Mime\SandboxTemplaterInterface;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Loader\SourceContextLoaderInterface;
use Twig\Source;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class SandboxLoader implements LoaderInterface, SourceContextLoaderInterface
{
    /**
     * @var string[]
     */
    private $availableNamespaces;

    /**
     * @var null|SandboxTemplaterInterface
     */
    private $sandboxTemplater;

    /**
     * Constructor.
     *
     * @param SandboxTemplaterInterface $sandboxTemplater    The sandbox templater
     * @param string[]                  $availableNamespaces The available namespaces
     */
    public function __construct(
        SandboxTemplaterInterface $sandboxTemplater,
        array $availableNamespaces = []
    ) {
        $this->sandboxTemplater = $sandboxTemplater;
        $this->availableNamespaces = $availableNamespaces;
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceContext($name): Source
    {
        return new Source('', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name): string
    {
        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     *
     * @throws
     */
    public function exists($name): bool
    {
        if ($this->sandboxTemplater->isSandboxed()
                && !\in_array($this->parseNamespace($name), $this->availableNamespaces, true)) {
            throw new LoaderError(sprintf('Unable to find template "%s".', $name));
        }

        return false;
    }

    /**
     * Retrieve the namespace of template name.
     *
     * @param string      $name    The template name
     * @param null|string $default The default namespace
     *
     * @return null|string
     */
    private function parseNamespace(string $name, ?string $default = null): ?string
    {
        if (0 === strpos($name, '@')) {
            if (false === $pos = strpos($name, '/')) {
                $pos = \strlen($name);
            }

            return substr($name, 1, $pos - 1);
        }

        return $default;
    }
}
