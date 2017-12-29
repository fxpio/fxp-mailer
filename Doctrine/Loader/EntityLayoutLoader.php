<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Doctrine\Loader;

use Fxp\Component\Mailer\Doctrine\Loader\Traits\EntityLoaderTrait;
use Fxp\Component\Mailer\Exception\UnknownLayoutException;
use Fxp\Component\Mailer\Loader\LayoutLoaderInterface;

/**
 * Entity layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EntityLayoutLoader implements LayoutLoaderInterface
{
    use EntityLoaderTrait;

    /**
     * {@inheritdoc}
     */
    public function load($name)
    {
        $repo = $this->om->getRepository($this->class);
        $layout = $repo->findOneBy(array(
            'name' => $name,
            'enabled' => true,
        ));

        if (null !== $layout) {
            return $layout;
        }

        throw new UnknownLayoutException($name);
    }
}
