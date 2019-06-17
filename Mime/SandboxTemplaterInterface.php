<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Mime;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface SandboxTemplaterInterface
{
    /**
     * Enable the sandbox.
     */
    public function enableSandbox(): void;

    /**
     * Disable the sandbox.
     */
    public function disableSandbox(): void;

    /**
     * Check if the sandbox is enabled.
     *
     * @return bool
     */
    public function isSandboxed(): bool;
}
