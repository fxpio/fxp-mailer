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

use Fxp\Component\Mailer\Model\TemplateMailInterface;
use Fxp\Component\Mailer\Model\TemplateMailTranslation;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail translation template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateMailTranslationTest extends TestCase
{
    public function testModel(): void
    {
        /** @var TemplateMailInterface $mail */
        $mail = $this->getMockBuilder(TemplateMailInterface::class)->getMock();
        $translation = new TemplateMailTranslation($mail);
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
