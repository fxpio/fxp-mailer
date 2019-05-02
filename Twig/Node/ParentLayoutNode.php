<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Twig\Node;

use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

/**
 * Get the filename of layout translated template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ParentLayoutNode extends AbstractExpression
{
    /**
     * Constructor.
     *
     * @param AbstractExpression $variables
     * @param int                $lineno
     * @param string             $tag
     */
    public function __construct(AbstractExpression $variables, $lineno, $tag = null)
    {
        $attr = ['variables' => $variables];
        parent::__construct([], $attr, $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Compiler $compiler A Twig_Compiler instance
     */
    public function compile(Compiler $compiler): void
    {
        $compiler
            ->raw('$this->env->getExtension(\'Fxp\Component\Mailer\Twig\Extension\TemplaterExtension\')')
            ->raw('->getTranslatedLayout(')
            ->subcompile($this->getAttribute('variables'))
            ->raw(')->getFile()')
        ;
    }
}
