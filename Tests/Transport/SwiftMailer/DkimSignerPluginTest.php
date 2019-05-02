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

use Fxp\Component\Mailer\Transport\SwiftMailer\DkimSignerPlugin;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for swift mailer dkim signer plugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class DkimSignerPluginTest extends TestCase
{
    /**
     * @var Filesystem
     */
    protected $fs;
    /**
     * @var string
     */
    protected $cache;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Swift_Message
     */
    protected $message;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|\Swift_Events_SendEvent
     */
    protected $event;

    /**
     * @var DkimSignerPlugin
     */
    protected $plugin;

    protected function setUp(): void
    {
        $this->fs = new Filesystem();
        $this->cache = sys_get_temp_dir().'/fxp_mailer_bundle_swiftmailer_dkim_signer';
        $this->fs->mkdir($this->cache);

        $path = $this->cache.'/private_key';
        $this->fs->dumpFile($path, 'CONTENT');

        $this->message = $this->getMockBuilder(\Swift_Message::class)
            ->disableOriginalConstructor()->getMock();

        $this->event = $this->getMockBuilder(\Swift_Events_SendEvent::class)
            ->disableOriginalConstructor()->getMock();

        $this->event->expects($this->any())
            ->method('getMessage')
            ->will($this->returnValue($this->message))
        ;

        $this->plugin = new DkimSignerPlugin($path, 'domain', 'selector');
    }

    public function testBeforeSendPerformed(): void
    {
        $this->message->expects($this->once())
            ->method('attachSigner')
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testBeforeSendPerformedWithInvalidPrivateKey(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/Impossible to read the private key of the DKIM swiftmailer signer "([\\w.~:\\\\\\/]+)\\/private_key"/');

        $path = $this->cache.'/private_key';
        $this->fs->remove($path);

        $this->message->expects($this->never())
            ->method('attachSigner')
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
            ->method('attachSigner')
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testBeforeSendPerformedWithDisabledPlugin(): void
    {
        $this->plugin->setEnabled(false);

        $this->message->expects($this->never())
            ->method('attachSigner')
        ;

        $this->plugin->beforeSendPerformed($this->event);
    }

    public function testSendPerformed(): void
    {
        $this->assertNull($this->plugin->sendPerformed($this->event));
    }
}
