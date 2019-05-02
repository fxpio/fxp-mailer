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

use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\LayoutTranslation;
use PHPUnit\Framework\TestCase;

/**
 * Tests for layout translation template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class LayoutTranslationTest extends TestCase
{
    public function testModel(): void
    {
        /** @var LayoutInterface $layout */
        $layout = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $translation = new LayoutTranslation($layout);
        $translation
            ->setLocale('fr')
            ->setLabel('Label of translation')
            ->setDescription('Description of translation')
            ->setBody('Body of translation')
        ;

        $this->assertSame($layout, $translation->getLayout());
        $this->assertSame('fr', $translation->getLocale());
        $this->assertSame('Label of translation', $translation->getLabel());
        $this->assertSame('Description of translation', $translation->getDescription());
        $this->assertSame('Body of translation', $translation->getBody());
    }
}
