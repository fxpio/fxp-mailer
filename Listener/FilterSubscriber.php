<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Listener;

use Fxp\Component\Mailer\Event\FilterPostRenderEvent;
use Fxp\Component\Mailer\Event\FilterPreSendEvent;
use Fxp\Component\Mailer\Filter\FilterRegistryInterface;
use Fxp\Component\Mailer\MailerEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * The filter listener of template and transport.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterSubscriber implements EventSubscriberInterface
{
    /**
     * @var FilterRegistryInterface
     */
    protected $registry;

    /**
     * Constructor.
     *
     * @param FilterRegistryInterface $registry The filters registry
     */
    public function __construct(FilterRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            MailerEvents::TEMPLATE_POST_RENDER => [
                'onPostRender', 0,
            ],
            MailerEvents::TRANSPORT_PRE_SEND => [
                'onPreSend', 0,
            ],
        ];
    }

    /**
     * Action on post render event of mail templater.
     *
     * @param FilterPostRenderEvent $event The event
     */
    public function onPostRender(FilterPostRenderEvent $event): void
    {
        foreach ($this->registry->getTemplateFilters() as $filter) {
            if (null !== ($mailRendered = $event->getMailRendered())
                    && $filter->supports($mailRendered)) {
                $filter->filter($mailRendered);
            }
        }
    }

    /**
     * Action on pre send event of mailer transport.
     *
     * @param FilterPreSendEvent $event The event
     */
    public function onPreSend(FilterPreSendEvent $event): void
    {
        foreach ($this->registry->getTransportFilters() as $filter) {
            if ($filter->supports($event->getTransport(), $event->getMessage(), $event->getMailRendered())) {
                $filter->filter($event->getTransport(), $event->getMessage(), $event->getMailRendered());
            }
        }
    }
}
