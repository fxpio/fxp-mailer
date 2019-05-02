<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Loader;

use Fxp\Component\Mailer\Exception\UnknownMailException;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\MailInterface;

/**
 * Interface for the mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface MailLoaderInterface
{
    /**
     * Load the mail template.
     *
     * @param string $name The unique name of mail template
     * @param string $type The mail type defined in MailTypes::TYPE_*
     *
     * @throws UnknownMailException When the mail template does not exist
     *
     * @return MailInterface
     */
    public function load($name, $type = MailTypes::TYPE_ALL);
}
