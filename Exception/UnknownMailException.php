<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Exception;

/**
 * Unknown Mail Template Exception.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class UnknownMailException extends UnknownTemplateException
{
    /**
     * Constructor.
     *
     * @param string $name The mail template name
     * @param string $type The mail type defined in MailTypes::TYPE_*
     */
    public function __construct(string $name, string $type)
    {
        parent::__construct(sprintf('The "%s" mail template does not exist with the "%s" type', $name, $type));
    }
}
