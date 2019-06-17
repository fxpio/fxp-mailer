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

use Symfony\Component\Mime\BodyRendererInterface;
use Symfony\Component\Mime\Message;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class SandboxBodyRenderer implements BodyRendererInterface
{
    /**
     * @var BodyRendererInterface
     */
    private $renderer;

    /**
     * @var null|SandboxTemplaterInterface
     */
    private $sandboxTemplater;

    /**
     * Constructor.
     *
     * @param BodyRendererInterface          $renderer         The body renderer
     * @param null|SandboxTemplaterInterface $sandboxTemplater The sandbox templater
     */
    public function __construct(BodyRendererInterface $renderer, ?SandboxTemplaterInterface $sandboxTemplater = null)
    {
        $this->renderer = $renderer;
        $this->sandboxTemplater = $sandboxTemplater;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Message $message): void
    {
        $isSandboxed = null;

        if (null !== $this->sandboxTemplater && $message instanceof SandboxInterface) {
            $isSandboxed = $this->sandboxTemplater->isSandboxed();
            $this->sandboxTemplater->enableSandbox();
        }

        $this->renderer->render($message);

        if (null !== $this->sandboxTemplater && false === $isSandboxed) {
            $this->sandboxTemplater->disableSandbox();
        }
    }
}
