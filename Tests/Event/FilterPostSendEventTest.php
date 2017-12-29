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

use Fxp\Component\Mailer\Event\FilterPostSendEvent;
use Fxp\Component\Mailer\MailRenderedInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for filter post send event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterPostSendEventTest extends TestCase
{
    public function testModel()
    {
        $result = true;
        $transport = 'transport_name';
        $message = new \stdClass();
        /* @var MailRenderedInterface $mailRendered */
        $mailRendered = $this->getMockBuilder(MailRenderedInterface::class)->getMock();

        $event = new FilterPostSendEvent($result, $transport, $message, $mailRendered);

        $this->assertSame($result, $event->isSend());
        $this->assertSame($transport, $event->getTransport());
        $this->assertSame($message, $event->getMessage());
        $this->assertSame($mailRendered, $event->getMailRendered());
    }
}
