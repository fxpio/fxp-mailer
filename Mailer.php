<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer;

use Fxp\Component\Mailer\Event\FilterPostSendEvent;
use Fxp\Component\Mailer\Event\FilterPreSendEvent;
use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * The mailer.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class Mailer implements MailerInterface
{
    /**
     * @var MailTemplaterInterface
     */
    protected $templater;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var TransportInterface[]
     */
    protected $transports;

    /**
     * @param MailTemplaterInterface   $templater  The mail templater
     * @param TransportInterface[]     $transports The transports
     * @param EventDispatcherInterface $dispatcher The event dispatcher
     */
    public function __construct(
        MailTemplaterInterface $templater,
        array $transports,
        EventDispatcherInterface $dispatcher
    ) {
        $this->templater = $templater;
        $this->dispatcher = $dispatcher;

        foreach ($transports as $transport) {
            $this->addTransport($transport);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addTransport(TransportInterface $transport): self
    {
        $this->transports[$transport->getName()] = $transport;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTransport(string $name): bool
    {
        return isset($this->transports[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getTransport(string $name): TransportInterface
    {
        if (!isset($this->transports[$name])) {
            $msg = sprintf('The "%s" transport does not exist', $name);

            throw new InvalidArgumentException($msg);
        }

        return $this->transports[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function send(
        string $transport,
        $message,
        ?string $template = null,
        array $variables = [],
        string $type = MailTypes::TYPE_ALL
    ): bool {
        $transportInstance = $this->getTransport($transport);
        $mailRendered = null !== $template
            ? $this->templater->render($template, $variables, $type)
            : null;

        $preEvent = new FilterPreSendEvent($transport, $message, $mailRendered);
        $this->dispatcher->dispatch(MailerEvents::TRANSPORT_PRE_SEND, $preEvent);

        $res = $transportInstance->send($preEvent->getMessage(), $preEvent->getMailRendered());

        $postEvent = new FilterPostSendEvent($res, $transport, $message, $mailRendered);
        $this->dispatcher->dispatch(MailerEvents::TRANSPORT_POST_SEND, $postEvent);

        return $res;
    }
}
