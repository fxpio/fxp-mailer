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
use Sonatra\Component\Mailer\Exception\UnknownMailException;
use Sonatra\Component\Mailer\Loader\MailLoaderInterface;
use Sonatra\Component\Mailer\MailTypes;
use Sonatra\Component\Mailer\Util\MailUtil;

/**
 * Entity mail loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
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
        $mail = $repo->findOneBy(array(
            'name' => $name,
            'enabled' => true,
            'type' => MailUtil::getValidTypes($type),
        ));

        if (null !== $mail) {
            return $mail;
        }

        throw new UnknownMailException($name, MailTypes::TYPE_ALL);
    }
}
