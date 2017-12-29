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

use Fxp\Component\Mailer\Model\LayoutTranslation as BaseLayoutTranslation;

/**
 * Entity for layout translation template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class LayoutTranslation extends BaseLayoutTranslation
{
    /**
     * @var int|string|null
     */
    protected $id;

    /**
     * Get the id.
     *
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }
}
