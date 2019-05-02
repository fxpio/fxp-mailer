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

use Fxp\Component\Mailer\Entity\LayoutTranslation;
use Fxp\Component\Mailer\Model\LayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for layout translation template entity.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class LayoutTranslationTest extends TestCase
{
    public function testEntity(): void
    {
        /** @var LayoutInterface $layout */
        $layout = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $translation = new LayoutTranslation($layout);

        $this->assertNull($translation->getId());
    }
}
