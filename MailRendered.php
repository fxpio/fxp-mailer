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

use Fxp\Component\Mailer\Model\MailInterface;

/**
 * The mail rendered.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailRendered implements MailRenderedInterface
{
    /**
     * @var MailInterface
     */
    protected $template;

    /**
     * @var null|string
     */
    protected $subject;

    /**
     * @var null|string
     */
    protected $htmlBody;

    /**
     * @var null|string
     */
    protected $body;

    /**
     * Constructor.
     *
     * @param MailInterface $template The mail template
     * @param null|string   $subject  The subject rendered
     * @param null|string   $htmlBody The HTML body rendered
     * @param null|string   $body     The body rendered
     */
    public function __construct(MailInterface $template, $subject, $htmlBody, $body)
    {
        $this->template = $template;
        $this->subject = $subject;
        $this->htmlBody = $htmlBody;
        $this->body = $body;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function setHtmlBody($htmlBody)
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    /**
     * {@inheritdoc}
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }
}
