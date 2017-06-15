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

use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use Sonatra\Component\Mailer\Entity\Mail;
use Sonatra\Component\Mailer\Model\MailTranslationInterface;

/**
 * Tests for mail template entity.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class MailTest extends TestCase
{
    public function testEntity()
    {
        /* @var MailTranslationInterface $translation */
        $translation = $this->getMockBuilder(MailTranslationInterface::class)->getMock();

        $layout = new Mail();

        $this->assertNull($layout->getId());

        $this->assertInstanceOf(Collection::class, $layout->getTranslations());

        $this->assertCount(0, $layout->getTranslations());
        $layout->addTranslation($translation);
        $this->assertCount(1, $layout->getTranslations());
        $layout->removeTranslation($translation);
        $this->assertCount(0, $layout->getTranslations());
    }
}
