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
 * Array template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ArrayTemplateLayoutLoader implements TemplateLayoutLoaderInterface
{
    /**
     * @var TemplateLayoutInterface[]
     */
    protected $layouts;

    /**
     * Constructor.
     *
     * @param TemplateLayoutInterface[] $layouts The layout template
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
     * @param TemplateLayoutInterface $layout The layout template
     */
    public function addLayout(TemplateLayoutInterface $layout): void
    {
        $this->layouts[$layout->getName()] = $layout;
    }

    /**
     * {@inheritdoc}
     */
    public function load(string $name): TemplateLayoutInterface
    {
        if (isset($this->layouts[$name]) && $this->layouts[$name]->isEnabled()) {
            return $this->layouts[$name];
        }

        throw new UnknownLayoutException($name);
    }
}
