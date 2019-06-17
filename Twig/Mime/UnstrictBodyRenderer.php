<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Twig\Mime;

use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Mime\Message;
use Twig\Environment;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class UnstrictBodyRenderer implements BodyRendererInterface
{
    /**
     * @var BodyRendererInterface
     */
    private $renderer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * Constructor.
     *
     * @param BodyRendererInterface $renderer The body renderer
     * @param Environment           $twig     The twig environment
     */
    public function __construct(BodyRendererInterface $renderer, Environment $twig)
    {
        $this->renderer = $renderer;
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Message $message): void
    {
        $isStrict = $this->twig->isStrictVariables();

        if ($isStrict) {
            $this->twig->disableStrictVariables();
        }

        $this->renderer->render($message);

        if ($isStrict) {
            $this->twig->enableStrictVariables();
        }
    }
}
