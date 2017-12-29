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
use Fxp\Component\Mailer\Exception\UnknownMailException;
use Fxp\Component\Mailer\Loader\MailLoaderInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Util\MailUtil;

/**
 * Entity mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EntityMailLoader implements MailLoaderInterface
{
    use EntityLoaderTrait;

    /**
     * {@inheritdoc}
     */
    public function load($name, $type = MailTypes::TYPE_ALL)
    {
        $repo = $this->om->getRepository($this->class);
        $mail = $repo->findOneBy([
            'name' => $name,
            'enabled' => true,
            'type' => MailUtil::getValidTypes($type),
        ]);

        if (null !== $mail) {
            return $mail;
        }

        throw new UnknownMailException($name, MailTypes::TYPE_ALL);
    }
}
