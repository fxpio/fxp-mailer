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
 * Interface for the layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface LayoutLoaderInterface
{
    /**
     * Load the layout template.
     *
     * @param string $name The unique name of layout template
     *
     * @throws UnknownLayoutException When the layout template does not exist
     *
     * @return LayoutInterface
     */
    public function load($name);
}
