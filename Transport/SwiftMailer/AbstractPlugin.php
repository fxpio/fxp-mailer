<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Transport\SwiftMailer;

/**
 * Base plugin for SwiftMailer.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractPlugin implements \Swift_Events_SendListener
{
    /**
     * @var array
     */
    protected $performed = [];

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * Defined if the plugin must be enabled or disabled.
     *
     * @param bool $enabled The enabled value
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;
    }

    /**
     * Check if the plugin is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
