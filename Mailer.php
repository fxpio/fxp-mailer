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
        foreach ($this->transporters as $transporter) {
            if ($transporter->supports($message, $envelope)) {
                $transporter->send($message, $envelope);

                return;
            }
        }

        throw new TransporterNotFoundException('No transporter was found to send the message');
    }
}
