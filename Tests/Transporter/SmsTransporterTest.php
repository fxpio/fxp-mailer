<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Transporter;

use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Exception\TransporterException;
use Fxp\Component\Mailer\Transporter\SmsTransporter;
use Fxp\Component\SmsSender\Exception\TransportException;
use Fxp\Component\SmsSender\Mime\Sms;
use Fxp\Component\SmsSender\SmsEnvelope;
use Fxp\Component\SmsSender\SmsSenderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\RawMessage;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class SmsTransporterTest extends TestCase
{
    /**
     * @var MockObject|SmsSenderInterface
     */
    protected $smsSender;

    /**
     * @var SmsTransporter
     */
    protected $transporter;

    protected function setUp(): void
    {
        $this->smsSender = $this->getMockBuilder(SmsSenderInterface::class)->getMock();
        $this->transporter = new SmsTransporter($this->smsSender);
    }

    protected function tearDown(): void
    {
        $this->smsSender = null;
        $this->transporter = null;
    }

    public function testSupports(): void
    {
        static::assertTrue($this->transporter->supports(new Sms()));
        static::assertFalse($this->transporter->supports(new Message()));
    }

    public function testSend(): void
    {
        $message = new RawMessage('');
        $envelope = $this->getMockBuilder(SmsEnvelope::class)->disableOriginalConstructor()->getMock();

        $this->smsSender->expects(static::once())
            ->method('send')
            ->with($message, $envelope)
        ;

        $this->transporter->send($message, $envelope);
    }

    public function testSendWithInvalidEnvelope(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The envelope of message must be an instance of Fxp\Component\SmsSender\SmsEnvelope ("stdClass" given)');

        $this->smsSender->expects(static::never())
            ->method('send')
        ;

        $this->transporter->send(new RawMessage(''), new \stdClass());
    }

    public function testSendWithSmsSenderTransportException(): void
    {
        $this->expectException(TransporterException::class);
        $this->expectExceptionMessage('TRANSPORT MESSAGE EXCEPTION');

        $exception = new TransportException('TRANSPORT MESSAGE EXCEPTION');
        $message = new RawMessage('');
        $envelope = $this->getMockBuilder(SmsEnvelope::class)->disableOriginalConstructor()->getMock();

        $this->smsSender->expects(static::once())
            ->method('send')
            ->with($message, $envelope)
            ->willThrowException($exception)
        ;

        $this->transporter->send($message, $envelope);
    }

    public function testHasRequiredFrom(): void
    {
        $this->smsSender->expects(static::once())->method('hasRequiredFrom')->willReturn(true);

        static::assertTrue($this->transporter->hasRequiredFrom());
    }
}
