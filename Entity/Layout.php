<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fxp\Component\Mailer\Model\Layout as BaseLayout;

/**
 * Entity for layout template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class Layout extends BaseLayout
{
    /**
     * @var null|int|string
     */
    protected $id;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->mails = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * Get the id.
     *
     * @return null|int|string
     */
    public function getId()
    {
        return $this->id;
    }
}
