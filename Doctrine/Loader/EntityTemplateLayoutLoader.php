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
use Fxp\Component\Mailer\Loader\TemplateLayoutLoaderInterface;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;

/**
 * Entity layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EntityTemplateLayoutLoader implements TemplateLayoutLoaderInterface
{
    use EntityLoaderTrait;

    /**
     * {@inheritdoc}
     */
    public function load(string $name): TemplateLayoutInterface
    {
        $repo = $this->om->getRepository($this->class);
        /** @var null|TemplateLayoutInterface $layout */
        $layout = $repo->findOneBy([
            'name' => $name,
            'enabled' => true,
        ]);

        if (null !== $layout) {
            return $layout;
        }

        throw new UnknownLayoutException($name);
    }
}
