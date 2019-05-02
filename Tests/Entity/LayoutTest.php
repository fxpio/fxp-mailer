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

use Doctrine\Common\Collections\Collection;
use Fxp\Component\Mailer\Entity\Layout;
use Fxp\Component\Mailer\Model\LayoutTranslationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for layout template entity.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class LayoutTest extends TestCase
{
    public function testEntity(): void
    {
        /** @var LayoutTranslationInterface $translation */
        $translation = $this->getMockBuilder(LayoutTranslationInterface::class)->getMock();

        $layout = new Layout();

        $this->assertNull($layout->getId());

        $this->assertInstanceOf(Collection::class, $layout->getMails());
        $this->assertInstanceOf(Collection::class, $layout->getTranslations());

        $this->assertCount(0, $layout->getTranslations());
        $layout->addTranslation($translation);
        $this->assertCount(1, $layout->getTranslations());
        $layout->removeTranslation($translation);
        $this->assertCount(0, $layout->getTranslations());
    }
}
