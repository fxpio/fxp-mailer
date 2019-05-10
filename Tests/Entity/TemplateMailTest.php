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
use Fxp\Component\Mailer\Entity\TemplateMail;
use Fxp\Component\Mailer\Model\TemplateMailTranslationInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail template entity.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateMailTest extends TestCase
{
    public function testEntity(): void
    {
        /** @var TemplateMailTranslationInterface $translation */
        $translation = $this->getMockBuilder(TemplateMailTranslationInterface::class)->getMock();

        $layout = new TemplateMail();

        $this->assertNull($layout->getId());

        $this->assertInstanceOf(Collection::class, $layout->getTranslations());

        $this->assertCount(0, $layout->getTranslations());
        $layout->addTranslation($translation);
        $this->assertCount(1, $layout->getTranslations());
        $layout->removeTranslation($translation);
        $this->assertCount(0, $layout->getTranslations());
    }
}
