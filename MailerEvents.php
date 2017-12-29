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

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
final class MailerEvents
{
    /**
     * The template.pre_render event is thrown before that an mail must be rendered.
     *
     * The event listener receives an
     * Fxp\Component\Mailer\Event\FilterPreRenderEvent instance.
     *
     * @var string
     */
    const TEMPLATE_PRE_RENDER = 'fxp_mailer.template.pre_render';

    /**
     * The template.post_render event is thrown after that an mail is rendered.
     *
     * The event listener receives an
     * Fxp\Component\Mailer\Event\FilterPostRenderEvent instance.
     *
     * @var string
     */
    const TEMPLATE_POST_RENDER = 'fxp_mailer.template.post_render';

    /**
     * The transport.pre_send event is thrown before that an mail must be sent
     * but after a render of mail.
     *
     * The event listener receives an
     * Fxp\Component\Mailer\Event\FilterPreSendEvent instance.
     *
     * @var string
     */
    const TRANSPORT_PRE_SEND = 'fxp_mailer.transport.pre_send';

    /**
     * The transport.post_send event is thrown after that an mail is sent.
     *
     * The event listener receives an
     * Fxp\Component\Mailer\Event\FilterPostSendEvent instance.
     *
     * @var string
     */
    const TRANSPORT_POST_SEND = 'fxp_mailer.transport.post_send';
}
