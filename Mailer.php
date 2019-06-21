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

use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Exception\TransporterNotFoundException;
use Fxp\Component\Mailer\Transporter\TransporterInterface;
use Symfony\Component\Mime\RawMessage;

/**
 * The mailer.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class Mailer implements MailerInterface
{
    /**
     * @var TransporterInterface[]
     */
    protected $transporters = [];

    /**
     * @param TransporterInterface[] $transporters The transporters
     */
    public function __construct(array $transporters)
    {
        foreach ($transporters as $transporter) {
            if (!$transporter instanceof TransporterInterface) {
                throw new InvalidArgumentException(sprintf(
                    'The transporter must be an instance of %s ("%s" given).',
                    TransporterInterface::class,
                    \get_class($transporter)
                ));
            }

            $this->transporters[] = $transporter;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(RawMessage $message, $envelope = null): void
    {
        $this->findTransporter($message, $envelope)->send($message, $envelope);
    }

    /**
     * {@inheritdoc}
     */
    public function hasRequiredFrom(RawMessage $message, $envelope = null): bool
    {
        return $this->findTransporter($message, $envelope)->hasRequiredFrom();
    }

    /**
     * Find the transporter.
     *
     * @param RawMessage  $message  The message
     * @param null|object $envelope The envelope
     *
     * @throws TransporterNotFoundException
     *
     * @return TransporterInterface
     */
    private function findTransporter(RawMessage $message, $envelope = null): TransporterInterface
    {
        foreach ($this->transporters as $transporter) {
            if ($transporter->supports($message, $envelope)) {
                return $transporter;
            }
        }

        throw new TransporterNotFoundException('No transporter was found for the message');
    }
}
