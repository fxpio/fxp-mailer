<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Doctrine\Loader;

use Sonatra\Component\Mailer\Doctrine\Loader\Traits\EntityLoaderTrait;
use Sonatra\Component\Mailer\Exception\UnknownLayoutException;
use Sonatra\Component\Mailer\Loader\LayoutLoaderInterface;

/**
 * Entity layout loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
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
