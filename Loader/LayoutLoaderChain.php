<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Loader;

use Sonatra\Component\Mailer\Exception\UnknownLayoutException;

/**
 * Layout loader chain.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class LayoutLoaderChain implements LayoutLoaderInterface
{
    /**
     * @var LayoutLoaderInterface[]
     */
    protected $loaders;

    /**
     * Constructor.
     *
     * @param LayoutLoaderInterface[] $loaders The layout loaders
     */
    public function __construct(array $loaders)
    {
        $this->loaders = array();

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    /**
     * Add the layout template loader.
     *
     * @param LayoutLoaderInterface $loader The layout loader
     */
    public function addLoader(LayoutLoaderInterface $loader)
    {
        $this->loaders[] = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function load($name)
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
