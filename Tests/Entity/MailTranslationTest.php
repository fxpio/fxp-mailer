<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Sonatra\Component\Mailer\Entity\MailTranslation;
use Sonatra\Component\Mailer\Model\MailInterface;

/**
 * Tests for mail translation template entity.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class MailTranslationTest extends TestCase
{
    public function testEntity()
    {
        /* @var MailInterface $mail */
        $mail = $this->getMockBuilder(MailInterface::class)->getMock();
        $translation = new MailTranslation($mail);

        $this->assertNull($translation->getId());
    }
}
