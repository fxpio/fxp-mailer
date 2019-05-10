<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Entity;

use Fxp\Component\Mailer\Entity\TemplateLayoutTranslation;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for layout translation template entity.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateLayoutTranslationTest extends TestCase
{
    public function testEntity(): void
    {
        /** @var TemplateLayoutInterface $layout */
        $layout = $this->getMockBuilder(TemplateLayoutInterface::class)->getMock();
        $translation = new TemplateLayoutTranslation($layout);

        $this->assertNull($translation->getId());
    }
}
