<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Transport\SwiftMailer;

use Fxp\Component\Mailer\Exception\RuntimeException;

/**
 * SwiftMailer DKIM Signer Plugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DkimSignerPlugin extends AbstractPlugin
{
    /**
     * @var string
     */
    protected $privateKeyPath;
    /**
     * @var string
     */
    protected $domain;
    /**
     * @var string
     */
    protected $selector;

    /**
     * Constructor.
     *
     * @param string $privateKeyPath The path of the private key
     * @param string $domain         The DKIM domain
     * @param string $selector       The DKIM selector
     */
    public function __construct(string $privateKeyPath, string $domain, string $selector)
    {
        $this->privateKeyPath = $privateKeyPath;
        $this->domain = $domain;
        $this->selector = $selector;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $event): void
    {
        $message = $event->getMessage();

        if (!$this->isEnabled() || !$message instanceof \Swift_Message
                || \in_array($message->getId(), $this->performed, true)) {
            return;
        }

        $signature = new \Swift_Signers_DKIMSigner($this->getPrivateKey(), $this->domain, $this->selector);
        $message->attachSigner($signature);
        $this->performed[] = $message->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function sendPerformed(\Swift_Events_SendEvent $event): void
    {
        // not used
    }

    /**
     * Get the private key.
     *
     * @throws RuntimeException When the private key cannot be read
     *
     * @return string
     */
    protected function getPrivateKey(): string
    {
        try {
            $privateKey = file_get_contents($this->privateKeyPath);
        } catch (\Exception $e) {
            $msg = 'Impossible to read the private key of the DKIM swiftmailer signer "%s"';

            throw new RuntimeException(sprintf($msg, $this->privateKeyPath));
        }

        return $privateKey;
    }
}
