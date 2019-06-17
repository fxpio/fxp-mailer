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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\SmtpEnvelope;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

/**
 * Email transporter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EmailTransporter implements TransporterInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(RawMessage $message, $envelope = null): bool
    {
        return $message instanceof Email;
    }

    /**
     * {@inheritdoc}
     */
    public function send(RawMessage $message, $envelope = null): void
    {
        if (null !== $envelope && !$envelope instanceof SmtpEnvelope) {
            throw new InvalidArgumentException(sprintf(
                'The envelope of message must be an instance of %s ("%s" given).',
                SmtpEnvelope::class,
                \get_class($envelope)
            ));
        }

        try {
            $this->mailer->send($message, $envelope);
        } catch (TransportExceptionInterface $e) {
            throw new TransporterException($e->getMessage(), 0, $e);
        }
    }
}
