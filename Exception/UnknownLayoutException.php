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
 * Unknown Layout Template Exception.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class UnknownLayoutException extends UnknownTemplateException
{
    /**
     * Constructor.
     *
     * @param string $name The layout template name
     */
    public function __construct($name)
    {
        parent::__construct(sprintf('The "%s" layout template does not exist', $name));
    }
}
