<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Doctrine\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Fxp\Component\Mailer\Model\TemplateMessageInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateMessageRepositoryInterface extends ObjectRepository
{
    /**
     * Find the template message by her name.
     *
     * @param string      $name   The template message name
     * @param null|string $type   The template type
     * @param null|string $locale The locale
     *
     * @return null|TemplateMessageInterface
     */
    public function findTemplate(string $name, ?string $type = null, ?string $locale = null): ?TemplateMessageInterface;
}
