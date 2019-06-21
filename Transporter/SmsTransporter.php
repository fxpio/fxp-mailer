<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Transporter;

use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Exception\TransporterException;
use Fxp\Component\SmsSender\Exception\TransportExceptionInterface;
use Fxp\Component\SmsSender\Mime\Sms;
use Fxp\Component\SmsSender\SmsEnvelope;
use Fxp\Component\SmsSender\SmsSenderInterface;
use Symfony\Component\Mime\RawMessage;

/**
 * Sms transporter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class SmsTransporter implements TransporterInterface
{
    private $smsSender;

    public function __construct(SmsSenderInterface $smsSender)
    {
        $this->smsSender = $smsSender;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(RawMessage $message, $envelope = null): bool
    {
        return $message instanceof Sms;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequiredFrom(): bool
    {
        return $this->smsSender->hasRequiredFrom();
    }

    /**
     * {@inheritdoc}
     */
    public function send(RawMessage $message, $envelope = null): void
    {
        if (null !== $envelope && !$envelope instanceof SmsEnvelope) {
            throw new InvalidArgumentException(sprintf(
                'The envelope of message must be an instance of %s ("%s" given).',
                SmsEnvelope::class,
                \get_class($envelope)
            ));
        }

        try {
            /* @var Sms $message */
            $this->smsSender->send($message, $envelope);
        } catch (TransportExceptionInterface $e) {
            throw new TransporterException($e->getMessage(), 0, $e);
        }
    }
}
