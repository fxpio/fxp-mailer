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

/**
 * Use mailer layout directly in twig template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class LayoutTokenParser extends \Twig_TokenParser_Include
{
    /**
     * {@inheritdoc}
     */
    public function parse(\Twig_Token $token)
    {
        $stream = $this->parser->getStream();

        $layout = $this->parser->getExpressionParser()->parseExpression();
        $parent = new ParentLayoutNode($layout, $token->getLine());

        list($variables, $only, $ignoreMissing) = $this->parseArguments();

        // inject a fake parent to make the parent() function work
        $stream->injectTokens([
            new \Twig_Token(\Twig_Token::BLOCK_START_TYPE, '', $token->getLine()),
            new \Twig_Token(\Twig_Token::NAME_TYPE, 'extends', $token->getLine()),
            new \Twig_Token(\Twig_Token::STRING_TYPE, '__parent__', $token->getLine()),
            new \Twig_Token(\Twig_Token::BLOCK_END_TYPE, '', $token->getLine()),
        ]);

        /** @var \Twig_Node_Module $module */
        $module = $this->parser->parse($stream, [$this, 'decideBlockEnd'], true);
        // override the parent with the correct one
        $module->setNode('parent', $parent);

        $this->parser->embedTemplate($module);

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new \Twig_Node_Embed($module->getTemplateName(), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }

    /**
     * Test the end of tag.
     *
     * @param \Twig_Token $token The token
     *
     * @return bool
     */
    public function decideBlockEnd(\Twig_Token $token)
    {
        return $token->test('endmailer_layout');
    }

    public function getTag()
    {
        return 'mailer_layout';
    }
}
