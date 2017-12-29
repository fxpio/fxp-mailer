<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Doctrine\Loader\Traits;

use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Trait for entity loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
trait EntityLoaderTrait
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry The doctrine registry
     * @param string          $class    The template class name
     */
    public function __construct(ManagerRegistry $registry, $class)
    {
        $this->om = $registry->getManagerForClass($class);
        $this->class = $class;
    }
}
