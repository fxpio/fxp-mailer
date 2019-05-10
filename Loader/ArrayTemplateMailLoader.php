<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Loader;

use Fxp\Component\Mailer\Exception\UnknownMailException;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\TemplateMailInterface;
use Fxp\Component\Mailer\Util\MailUtil;

/**
 * Array template mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ArrayTemplateMailLoader implements TemplateMailLoaderInterface
{
    /**
     * @var TemplateMailInterface[]
     */
    protected $mails;

    /**
     * Constructor.
     *
     * @param TemplateMailInterface[] $mails The mail template
     */
    public function __construct(array $mails)
    {
        $this->mails = [];

        foreach ($mails as $mail) {
            $this->addMail($mail);
        }
    }

    /**
     * Add the mail template.
     *
     * @param TemplateMailInterface $mail The mail template
     */
    public function addMail(TemplateMailInterface $mail): void
    {
        $this->mails[$mail->getName()] = $mail;
    }

    /**
     * {@inheritdoc}
     */
    public function load(string $name, string $type = MailTypes::TYPE_ALL): TemplateMailInterface
    {
        if (isset($this->mails[$name]) && MailUtil::isValid($this->mails[$name], $type)) {
            return $this->mails[$name];
        }

        throw new UnknownMailException($name, $type);
    }
}
