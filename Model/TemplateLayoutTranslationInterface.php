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
 * Interface for the layout translation template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
interface TemplateLayoutTranslationInterface extends TemplateTranslationInterface
{
    /**
     * Get the reference layout.
     *
     * @return TemplateLayoutInterface
     */
    public function getLayout(): TemplateLayoutInterface;
}
