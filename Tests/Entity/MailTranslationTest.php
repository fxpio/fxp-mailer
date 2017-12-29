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

use Fxp\Component\Mailer\Entity\MailTranslation;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail translation template entity.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
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
