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
use Sonatra\Component\Mailer\Model\LayoutInterface;

/**
 * Interface for the layout loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
interface LayoutLoaderInterface
{
    /**
     * Load the layout template.
     *
     * @param string $name The unique name of layout template
     *
     * @return LayoutInterface
     *
     * @throws UnknownLayoutException When the layout template does not exist
     */
    public function load($name);
}
