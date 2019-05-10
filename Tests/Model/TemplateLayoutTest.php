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

use Fxp\Component\Mailer\Model\TemplateLayout;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use Fxp\Component\Mailer\Model\TemplateLayoutTranslation;
use Fxp\Component\Mailer\Model\TemplateLayoutTranslationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for layout template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateLayoutTest extends TestCase
{
    public function testModel(): void
    {
        /** @var TemplateLayoutTranslationInterface $translation */
        $translation = $this->getMockBuilder(TemplateLayoutTranslationInterface::class)->getMock();

        $layout = new TemplateLayout();
        $layout->setTranslationDomain('domain');

        $this->assertInternalType('array', $layout->getMails());
        $this->assertInternalType('array', $layout->getTranslations());

        $this->assertCount(0, $layout->getTranslations());
        $layout->addTranslation($translation);
        $this->assertCount(1, $layout->getTranslations());
        $layout->removeTranslation($translation);
        $this->assertCount(0, $layout->getTranslations());
        $this->assertSame('domain', $layout->getTranslationDomain());
    }

    public function testGetTranslation(): void
    {
        /** @var TemplateLayout $layout */
        /** @var TemplateLayoutTranslation $translation */
        list($layout, $translation) = $this->getModels('fr_fr');

        $translated = $layout->getTranslation('fr_fr');

        $this->assertInstanceOf(TemplateLayoutInterface::class, $translated);
        $this->assertNotSame($translation, $translated);
        $this->assertSame($translation->getLabel(), $translated->getLabel());
        $this->assertSame($translation->getDescription(), $translated->getDescription());
        $this->assertSame($translation->getBody(), $translated->getBody());

        $this->assertSame($translated, $layout->getTranslation('fr_fr'));
    }

    public function testGetFallbackTranslation(): void
    {
        /** @var TemplateLayout $layout */
        /** @var TemplateLayoutTranslation $translation */
        list($layout, $translation) = $this->getModels('fr');

        $translated = $layout->getTranslation('fr_fr');

        $this->assertInstanceOf(TemplateLayoutInterface::class, $translated);
        $this->assertNotSame($translation, $translated);
        $this->assertSame($translation->getLabel(), $translated->getLabel());
        $this->assertSame($translation->getDescription(), $translated->getDescription());
        $this->assertSame($translation->getBody(), $translated->getBody());

        $this->assertSame($translated, $layout->getTranslation('fr_fr'));
    }

    public function testGetNotTranslation(): void
    {
        /** @var TemplateLayout $layout */
        /** @var TemplateLayoutTranslation $translation */
        list($layout, $translation) = $this->getModels('fr_fr');

        $translated = $layout->getTranslation('fr');

        $this->assertInstanceOf(TemplateLayoutInterface::class, $translated);
        $this->assertNotSame($translation, $translated);
        $this->assertNotSame($translation->getLabel(), $translated->getLabel());
        $this->assertNotSame($translation->getDescription(), $translated->getDescription());
        $this->assertNotSame($translation->getBody(), $translated->getBody());

        $this->assertSame($translated, $layout->getTranslation('fr'));
    }

    /**
     * Get the layout and translation models.
     *
     * @param string $locale The locale
     *
     * @return array The layout and translation
     */
    protected function getModels($locale)
    {
        $layout = new TemplateLayout();
        $layout
            ->setName('test')
            ->setLabel('Label of template')
            ->setDescription('Description of template')
            ->setBody('Body of template')
        ;

        $translation = new TemplateLayoutTranslation($layout);
        $translation
            ->setLocale($locale)
            ->setLabel('Label of translated template')
            ->setDescription('Description of translated template')
            ->setBody('Body of translated template')
        ;

        return [$layout, $translation];
    }
}
