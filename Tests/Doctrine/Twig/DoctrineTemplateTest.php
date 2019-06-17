<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Doctrine\Twig;

use Fxp\Component\Mailer\Doctrine\Twig\DoctrineTemplate;
use Fxp\Component\Mailer\Model\TemplateMessageInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class DoctrineTemplateTest extends TestCase
{
    public function testGetters(): void
    {
        $datetime = new \DateTime();

        /** @var MockObject|TemplateMessageInterface $templateMessage */
        $templateMessage = $this->getMockBuilder(TemplateMessageInterface::class)->getMock();

        $templateMessage->expects($this->once())
            ->method('getId')
            ->willReturn(42)
        ;
        $templateMessage->expects($this->once())
            ->method('getName')
            ->willReturn('template_name')
        ;
        $templateMessage->expects($this->once())
            ->method('getType')
            ->willReturn('template_type')
        ;
        $templateMessage->expects($this->once())
            ->method('getBody')
            ->willReturn('template body')
        ;
        $templateMessage->expects($this->once())
            ->method('getUpdatedAt')
            ->willReturn($datetime)
        ;

        $doctrineTemplate = new DoctrineTemplate($templateMessage);

        $this->assertSame(42, $doctrineTemplate->getId());
        $this->assertSame('template_name', $doctrineTemplate->getName());
        $this->assertSame('template_type', $doctrineTemplate->getType());
        $this->assertSame('template body', $doctrineTemplate->getBody());
        $this->assertNotSame($datetime, $doctrineTemplate->getUpdatedAt());
        $this->assertEquals($datetime, $doctrineTemplate->getUpdatedAt());
    }
}
