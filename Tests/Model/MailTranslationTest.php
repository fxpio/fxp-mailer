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

use Fxp\Component\Mailer\Model\MailInterface;
use Fxp\Component\Mailer\Model\MailTranslation;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail translation template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailTranslationTest extends TestCase
{
    public function testModel()
    {
        /* @var MailInterface $mail */
        $mail = $this->getMockBuilder(MailInterface::class)->getMock();
        $translation = new MailTranslation($mail);
        $translation
            ->setSubject('Subject of translation')
            ->setHtmlBody('HTML body of translation')
            ->setLocale('fr')
            ->setLabel('Label of translation')
            ->setDescription('Description of translation')
            ->setBody('Body of translation')
        ;

        $this->assertSame($mail, $translation->getMail());
        $this->assertSame('fr', $translation->getLocale());
        $this->assertSame('Label of translation', $translation->getLabel());
        $this->assertSame('Description of translation', $translation->getDescription());
        $this->assertSame('Subject of translation', $translation->getSubject());
        $this->assertSame('HTML body of translation', $translation->getHtmlBody());
        $this->assertSame('Body of translation', $translation->getBody());
    }
}
