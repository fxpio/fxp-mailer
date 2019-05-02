<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Transport\SwiftMailer;

use Fxp\Component\Mailer\Transport\SwiftMailer\EmbedImagePlugin;
use PHPUnit\Framework\TestCase;

/**
 * Tests for swift mailer embed image plugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class EmbedImagePluginTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Swift_Message
     */
    protected $message;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Swift_Events_SendEvent
     */
    protected $event;

    /**
     * @var EmbedImagePlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        $this->message = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()->getMock();

        $this->event = $this->getMockBuilder(\Swift_Events_SendEvent::class)
            ->disableOriginalConstructor()->getMock();

        $this->event->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue($this->message))
        ;

        $this->plugin = new EmbedImagePlugin();
    }

    public function testBeforeSendPerformed(): void
    {
        $messageId = 'message_id';
        $html = '<html><body><img src="test.png"><p>Test.</p><img src="test.png"></body></html>';
        $htmlConverted = '<html><body><img src="cid:EMBED_CID"><p>Test.</p><img src="cid:EMBED_CID"></body></html>';
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadHTML($htmlConverted);
        $htmlConverted = $document->saveHTML();

        $this->message->expects($this->atLeastOnce())
            ->method('getBody')
            ->will($this->returnValue($html))
        ;

        $this->message->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue($messageId))
        ;

        $this->message->expects($this->once())
            ->method('embed')
            ->will($this->returnValue('cid:EMBED_CID'))
        ;

        $this->message->expects($this->once())
            ->method('setBody')
            ->with($htmlConverted)
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testBeforeSendPerformedWithAlreadyEmbeddedImage(): void
    {
        $messageId = 'message_id';
        $html = '<html><body><img src="cid:ALREADY_EMBED_CID"><p>Test.</p><img src="test.png"></body></html>';
        $htmlConverted = '<html><body><img src="cid:ALREADY_EMBED_CID"><p>Test.</p><img src="cid:EMBED_CID"></body></html>';
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadHTML($htmlConverted);
        $htmlConverted = $document->saveHTML();

        $this->message->expects($this->atLeastOnce())
            ->method('getBody')
            ->will($this->returnValue($html))
        ;

        $this->message->expects($this->atLeastOnce())
            ->method('getId')
            ->will($this->returnValue($messageId))
        ;

        $this->message->expects($this->once())
            ->method('embed')
            ->will($this->returnValue('cid:EMBED_CID'))
        ;

        $this->message->expects($this->once())
            ->method('setBody')
            ->with($htmlConverted)
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testBeforeSendPerformedWithInvalidMessage(): void
    {
        $this->event = $this->getMockBuilder(\Swift_Events_SendEvent::class)
            ->disableOriginalConstructor()->getMock();

        $this->event->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue(new \stdClass()))
        ;

        $this->message->expects($this->never())
            ->method('embed')
        ;

        $this->message->expects($this->never())
            ->method('setBody')
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testBeforeSendPerformedWithEmptyBody(): void
    {
        $this->message->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue(null))
        ;

        $this->message->expects($this->never())
            ->method('embed')
        ;

        $this->message->expects($this->never())
            ->method('setBody')
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testBeforeSendPerformedWithDisabledPlugin(): void
    {
        $this->plugin->setEnabled(false);

        $this->message->expects($this->never())
            ->method('embed')
        ;

        $this->message->expects($this->never())
            ->method('setBody')
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testSendPerformed(): void
    {
        $this->assertNull($this->plugin->sendPerformed($this->event));
    }
}
