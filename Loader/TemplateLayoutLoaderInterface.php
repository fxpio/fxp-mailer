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
 * Interface for the template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateLayoutLoaderInterface
{
    /**
     * Load the layout template.
     *
     * @param string $name The unique name of layout template
     *
     * @throws UnknownLayoutException When the layout template does not exist
     *
     * @return TemplateLayoutInterface
     */
    public function load(string $name): TemplateLayoutInterface;
}
