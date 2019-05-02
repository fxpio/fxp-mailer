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
use Twig\Compiler;
use Twig\Node\Expression\AbstractExpression;

/**
 * Tests for twig parent layout node.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ParentLayoutNodeTest extends TestCase
{
    public function testBasic(): void
    {
        /** @var AbstractExpression $variables */
        $variables = $this->getMockForAbstractClass(AbstractExpression::class);
        /** @var Compiler|\PHPUnit_Framework_MockObject_MockObject $compiler */
        $compiler = $this->getMockBuilder(Compiler::class)->disableOriginalConstructor()->getMock();
        $compiler->expects($this->any())
            ->method('raw')
            ->will($this->returnValue($compiler))
        ;

        $compiler->expects($this->any())
            ->method('subcompile')
            ->will($this->returnValue($compiler))
        ;

        $node = new ParentLayoutNode($variables, 42, 'test');

        $node->compile($compiler);
        $this->assertTrue(true);
    }
}
