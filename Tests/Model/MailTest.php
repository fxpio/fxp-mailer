<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Model;

use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\Mail;
use Fxp\Component\Mailer\Model\MailInterface;
use Fxp\Component\Mailer\Model\MailTranslation;
use Fxp\Component\Mailer\Model\MailTranslationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailTest extends TestCase
{
    public function testModel()
    {
        /* @var LayoutInterface $layout */
        $layout = $this->getMockBuilder(LayoutInterface::class)->getMock();
        /* @var MailTranslationInterface $translation */
        $translation = $this->getMockBuilder(MailTranslationInterface::class)->getMock();

        $mail = new Mail();
        $mail
            ->setType(MailTypes::TYPE_PRINT)
            ->setSubject('Subject of template')
            ->setHtmlBody('HTML Body of template')
            ->setBody('Body of template')
            ->setLayout($layout)
            ->setTranslationDomain('domain')
        ;

        $this->assertInternalType('array', $mail->getTranslations());

        $this->assertCount(0, $mail->getTranslations());
        $mail->addTranslation($translation);
        $this->assertCount(1, $mail->getTranslations());
        $mail->removeTranslation($translation);
        $this->assertCount(0, $mail->getTranslations());

        $this->assertSame(MailTypes::TYPE_PRINT, $mail->getType());
        $this->assertSame('Subject of template', $mail->getSubject());
        $this->assertSame('HTML Body of template', $mail->getHtmlBody());
        $this->assertSame('Body of template', $mail->getBody());
        $this->assertSame($layout, $mail->getLayout());
        $this->assertSame('domain', $mail->getTranslationDomain());
    }

    public function testGetTranslation()
    {
        /* @var Mail $mail */
        /* @var MailTranslation $translation */
        list($mail, $translation) = $this->getModels('fr_fr');

        $translated = $mail->getTranslation('fr_fr');

        $this->assertInstanceOf(MailInterface::class, $translated);
        $this->assertNotSame($translation, $translated);
        $this->assertSame($translation->getLabel(), $translated->getLabel());
        $this->assertSame($translation->getDescription(), $translated->getDescription());
        $this->assertSame($translation->getBody(), $translated->getBody());

        $this->assertSame($translated, $mail->getTranslation('fr_fr'));
    }

    public function testGetFallbackTranslation()
    {
        /* @var Mail $mail */
        /* @var MailTranslation $translation */
        list($mail, $translation) = $this->getModels('fr');

        $translated = $mail->getTranslation('fr_fr');

        $this->assertInstanceOf(MailInterface::class, $translated);
        $this->assertNotSame($translation, $translated);
        $this->assertSame($translation->getLabel(), $translated->getLabel());
        $this->assertSame($translation->getDescription(), $translated->getDescription());
        $this->assertSame($translation->getBody(), $translated->getBody());

        $this->assertSame($translated, $mail->getTranslation('fr_fr'));
    }

    public function testGetNotTranslation()
    {
        /* @var Mail $mail */
        /* @var MailTranslation $translation */
        list($mail, $translation) = $this->getModels('fr_fr');

        $translated = $mail->getTranslation('fr');

        $this->assertInstanceOf(MailInterface::class, $translated);
        $this->assertNotSame($translation, $translated);
        $this->assertNotSame($translation->getLabel(), $translated->getLabel());
        $this->assertNotSame($translation->getDescription(), $translated->getDescription());
        $this->assertNotSame($translation->getBody(), $translated->getBody());

        $this->assertSame($translated, $mail->getTranslation('fr'));
    }

    /**
     * Get the mail and translation models.
     *
     * @param string $locale The locale
     *
     * @return array The mail and translation
     */
    protected function getModels($locale)
    {
        $mail = new Mail();
        $mail
            ->setName('test')
            ->setLabel('Label of template')
            ->setDescription('Description of template')
            ->setSubject('Subject of template')
            ->setHtmlBody('HTML Body of template')
            ->setBody('Body of template')
        ;

        $translation = new MailTranslation($mail);
        $translation
            ->setSubject('Subject of translated template')
            ->setHtmlBody('HTML Body of translated template')
            ->setSubject('Subject of template')
            ->setHtmlBody('HTML Body of template')
            ->setLocale($locale)
            ->setLabel('Label of translated template')
            ->setDescription('Description of translated template')
            ->setBody('Body of translated template')
        ;

        return [$mail, $translation];
    }
}
