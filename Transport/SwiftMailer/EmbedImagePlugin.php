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

use Fxp\Component\Mailer\Util\EmbedImageUtil;

/**
 * SwiftMailer Embed Image Plugin.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EmbedImagePlugin extends AbstractPlugin
{
    /**
     * @var string
     */
    protected $webDir;

    /**
     * @var string
     */
    protected $hostPattern;

    /**
     * Constructor.
     *
     * @param null|string $webDir      The web directory
     * @param string      $hostPattern The pattern of allowed host
     */
    public function __construct($webDir = null, $hostPattern = '/(.*)+/')
    {
        $this->webDir = (string) $webDir;
        $this->hostPattern = $hostPattern;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSendPerformed(\Swift_Events_SendEvent $event): void
    {
        $message = $event->getMessage();

        if (!$this->isEnabled() || !$message instanceof \Swift_Message
                || \in_array($message->getId(), $this->performed, true) || null === $message->getBody()) {
            return;
        }

        $dom = new \DOMDocument('1.0', 'utf-8');
        $internalErrors = libxml_use_internal_errors(true);
        $dom->loadHTML($message->getBody());
        libxml_use_internal_errors($internalErrors);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//img/@src');
        $images = [];

        foreach ($nodes as $node) {
            $this->embedImage($message, $node, $images);
        }

        $message->setBody($dom->saveHTML(), 'text/html');
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
     * Embed the image in message and replace the image link by attachment id.
     *
     * @param \Swift_Message $message The swift mailer message
     * @param \DOMAttr       $node    The dom attribute of image
     * @param array          $images  The map of image ids passed by reference
     */
    protected function embedImage(\Swift_Message $message, \DOMAttr $node, array &$images): void
    {
        if (0 === strpos($node->nodeValue, 'cid:')) {
            return;
        }

        if (isset($images[$node->nodeValue])) {
            $node->nodeValue = $images[$node->nodeValue];
        } else {
            $node->nodeValue = EmbedImageUtil::getLocalPath($node->nodeValue, $this->webDir, $this->hostPattern);
            $cid = $message->embed(\Swift_Image::fromPath($node->nodeValue));
            $images[$node->nodeValue] = $cid;
            $node->nodeValue = $cid;
        }
    }
}
