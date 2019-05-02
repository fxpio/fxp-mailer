<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Event;

use Fxp\Component\Mailer\Event\FilterPreSendEvent;
use Fxp\Component\Mailer\MailRenderedInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for filter pre send event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class FilterPreSendEventTest extends TestCase
{
    public function testModel(): void
    {
        $transport = 'transport_name';
        $message = new \stdClass();
        /** @var MailRenderedInterface $mailRendered */
        $mailRendered = $this->getMockBuilder(MailRenderedInterface::class)->getMock();

        $event = new FilterPreSendEvent($transport, $message, $mailRendered);

        $this->assertSame($transport, $event->getTransport());
        $this->assertSame($message, $event->getMessage());
        $this->assertSame($mailRendered, $event->getMailRendered());

        $transport2 = 'new_transport_name';
        $message2 = new \stdClass();
        $mailRendered2 = null;

        $event->setTransport($transport2);
        $event->setMessage($message2);
        $event->setMailRendered($mailRendered2);

        $this->assertSame($transport2, $event->getTransport());
        $this->assertSame($message2, $event->getMessage());
        $this->assertSame($mailRendered2, $event->getMailRendered());
    }
}
