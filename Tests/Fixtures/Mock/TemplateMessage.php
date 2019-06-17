<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Fixtures\Mock;

use Fxp\Component\Mailer\Model\TemplateMessageInterface;
use Fxp\Component\Mailer\Model\Traits\TemplateMessageTrait;
use Gedmo\Translatable\Translatable;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TemplateMessage implements TemplateMessageInterface, Translatable
{
    use TemplateMessageTrait;

    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
