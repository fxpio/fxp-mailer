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

/**
 * Get the filename of layout translated template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ParentLayoutNode extends \Twig_Node_Expression
{
    /**
     * Constructor.
     *
     * @param \Twig_Node_Expression $variables
     * @param int                   $lineno
     * @param string                $tag
     */
    public function __construct(\Twig_Node_Expression $variables, $lineno, $tag = null)
    {
        $attr = ['variables' => $variables];
        parent::__construct([], $attr, $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler $compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $compiler
            ->raw('$this->env->getExtension(\'Fxp\Component\Mailer\Twig\Extension\TemplaterExtension\')')
            ->raw('->getTranslatedLayout(')
            ->subcompile($this->getAttribute('variables'))
            ->raw(')->getFile()')
        ;
    }
}
