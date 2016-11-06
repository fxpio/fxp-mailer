<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Model;

use Sonatra\Component\Mailer\Exception\InvalidArgumentException;
use Sonatra\Component\Mailer\Model\Traits\FileTrait;

/**
 * Model for twig file mail template.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TwigMail extends Mail implements TwigTemplateInterface
{
    use FileTrait;

    /**
     * Constructor.
     *
     * @param string|null $file The file name
     */
    public function __construct($file = null)
    {
        $this->setFile($file);
        $this->subject = 'subject';
        $this->htmlBody = 'html_body';
        $this->body = 'body';
    }

    /**
     * {@inheritdoc}
     */
    protected function support($file)
    {
        if (null !== $file && 'twig' !== pathinfo($file, PATHINFO_EXTENSION)) {
            $msg = 'The "%s" file is not supported by the mail file template';
            throw new InvalidArgumentException(sprintf($msg, $file));
        }
    }
}
