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

use Fxp\Component\Mailer\Entity\TemplateMailTranslation;
use Fxp\Component\Mailer\Model\TemplateMailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail translation template entity.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateMailTranslationTest extends TestCase
{
    public function testEntity(): void
    {
        /** @var TemplateMailInterface $mail */
        $mail = $this->getMockBuilder(TemplateMailInterface::class)->getMock();
        $translation = new TemplateMailTranslation($mail);

        $this->assertNull($translation->getId());
    }
}
