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
use Fxp\Component\Mailer\Model\LayoutInterface;

/**
 * Array layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ArrayLayoutLoader implements LayoutLoaderInterface
{
    /**
     * @var LayoutInterface[]
     */
    protected $layouts;

    /**
     * Constructor.
     *
     * @param LayoutInterface[] $layouts The layout template
     */
    public function __construct(array $layouts)
    {
        $this->layouts = [];

        foreach ($layouts as $layout) {
            $this->addLayout($layout);
        }
    }

    /**
     * Add the layout template.
     *
     * @param LayoutInterface $layout The layout template
     */
    public function addLayout(LayoutInterface $layout)
    {
        $this->layouts[$layout->getName()] = $layout;
    }

    /**
     * {@inheritdoc}
     */
    public function load($name)
    {
        if (isset($this->layouts[$name]) && $this->layouts[$name]->isEnabled()) {
            return $this->layouts[$name];
        }

        throw new UnknownLayoutException($name);
    }
}
