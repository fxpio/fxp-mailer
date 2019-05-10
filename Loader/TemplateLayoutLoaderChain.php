<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Loader;

use Fxp\Component\Mailer\Exception\UnknownLayoutException;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;

/**
 * Template layout loader chain.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TemplateLayoutLoaderChain implements TemplateLayoutLoaderInterface
{
    /**
     * @var TemplateLayoutLoaderInterface[]
     */
    protected $loaders;

    /**
     * Constructor.
     *
     * @param TemplateLayoutLoaderInterface[] $loaders The layout loaders
     */
    public function __construct(array $loaders)
    {
        $this->loaders = [];

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    /**
     * Add the layout template loader.
     *
     * @param TemplateLayoutLoaderInterface $loader The layout loader
     */
    public function addLoader(TemplateLayoutLoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function load(string $name): TemplateLayoutInterface
    {
        foreach ($this->loaders as $loader) {
            try {
                return $loader->load($name);
            } catch (UnknownLayoutException $e) {
                // do nothing, check the next loader
            }
        }

        throw new UnknownLayoutException($name);
    }
}
