<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Twig\TokenParser;

use Fxp\Component\Mailer\Twig\Node\ParentLayoutNode;
use Twig\Node\EmbedNode;
use Twig\Node\ModuleNode;
use Twig\Node\Node;
use Twig\Token;
use Twig\TokenParser\IncludeTokenParser;

/**
 * Use mailer layout directly in twig template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class LayoutTokenParser extends IncludeTokenParser
{
    /**
     * {@inheritdoc}
     */
    public function parse(Token $token): Node
    {
        $stream = $this->parser->getStream();

        $layout = $this->parser->getExpressionParser()->parseExpression();
        $parent = new ParentLayoutNode($layout, $token->getLine());

        list($variables, $only, $ignoreMissing) = $this->parseArguments();

        // inject a fake parent to make the parent() function work
        $stream->injectTokens([
            new Token(Token::BLOCK_START_TYPE, '', $token->getLine()),
            new Token(Token::NAME_TYPE, 'extends', $token->getLine()),
            new Token(Token::STRING_TYPE, '__parent__', $token->getLine()),
            new Token(Token::BLOCK_END_TYPE, '', $token->getLine()),
        ]);

        /** @var ModuleNode $module */
        $module = $this->parser->parse($stream, [$this, 'decideBlockEnd'], true);
        // override the parent with the correct one
        $module->setNode('parent', $parent);

        $this->parser->embedTemplate($module);

        $stream->expect(Token::BLOCK_END_TYPE);

        return new EmbedNode($module->getTemplateName(), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }

    /**
     * Test the end of tag.
     *
     * @param Token $token The token
     *
     * @return bool
     */
    public function decideBlockEnd(Token $token): bool
    {
        return $token->test('endmailer_layout');
    }

    public function getTag(): string
    {
        return 'mailer_layout';
    }
}
