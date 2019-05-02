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

use Fxp\Component\Mailer\Model\MailTranslation as BaseMailTranslation;

/**
 * Entity for mail translation template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailTranslation extends BaseMailTranslation
{
    /**
     * @var null|int|string
     */
    protected $id;

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
