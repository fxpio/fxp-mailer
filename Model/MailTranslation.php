<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Model;

/**
 * Model for mail translation template.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailTranslation implements MailTranslationInterface
{
    /**
     * @var MailInterface
     */
    protected $mail;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var null|string
     */
    protected $label;

    /**
     * @var null|string
     */
    protected $description;

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
     * @param MailInterface $mail The mail
     */
    public function __construct(MailInterface $mail)
    {
        $mail->addTranslation($this);
        $this->mail = $mail;
    }

    /**
     * {@inheritdoc}
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
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
