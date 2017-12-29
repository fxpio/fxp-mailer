<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Twig\Node;

use Fxp\Component\Mailer\Twig\Node\ParentLayoutNode;
use PHPUnit\Framework\TestCase;

/**
 * Tests for twig parent layout node.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ParentLayoutNodeTest extends TestCase
{
    public function testBasic()
    {
        /* @var \Twig_Node_Expression $variables */
        $variables = $this->getMockBuilder(\Twig_Node_Expression::class)->disableOriginalConstructor()->getMock();
        /* @var \Twig_Compiler|\PHPUnit_Framework_MockObject_MockObject $compiler */
        $compiler = $this->getMockBuilder(\Twig_Compiler::class)->disableOriginalConstructor()->getMock();
        $compiler->expects($this->any())
            ->method('raw')
            ->will($this->returnValue($compiler));

        $compiler->expects($this->any())
            ->method('subcompile')
            ->will($this->returnValue($compiler));

        $node = new ParentLayoutNode($variables, 42, 'test');

        $this->assertNull($node->compile($compiler));
    }
}
