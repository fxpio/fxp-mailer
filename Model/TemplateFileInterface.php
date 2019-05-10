<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Model;

/**
 * Interface for the template file.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateFileInterface
{
    /**
     * Set the file name.
     *
     * @param string $file
     *
     * @return static
     */
    public function setFile(?string $file);

    /**
     * Get the file name.
     *
     * @return string
     */
    public function getFile(): ?string;
}
