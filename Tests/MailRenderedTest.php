<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests;

use Fxp\Component\Mailer\MailRendered;
use Fxp\Component\Mailer\Model\TemplateMailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for mail rendered.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class MailRenderedTest extends TestCase
{
    public function testModel(): void
    {
        /** @var TemplateMailInterface $template */
        $template = $this->getMockBuilder(TemplateMailInterface::class)->getMock();
        $subject = 'Subject of mail';
        $htmlBody = 'HTML body of mail';
        $body = 'Body of mail';

        $rendered = new MailRendered($template, $subject, $htmlBody, $body);

        $this->assertSame($template, $rendered->getTemplate());
        $this->assertSame($subject, $rendered->getSubject());
        $this->assertSame($htmlBody, $rendered->getHtmlBody());
        $this->assertSame($body, $rendered->getBody());

        $subject2 = 'Subject of mail 2';
        $htmlBody2 = 'HTML body of mail 2';
        $body2 = 'Body of mail 2';

        $rendered->setSubject($subject2);
        $rendered->setHtmlBody($htmlBody2);
        $rendered->setBody($body2);

        $this->assertSame($template, $rendered->getTemplate());
        $this->assertSame($subject2, $rendered->getSubject());
        $this->assertSame($htmlBody2, $rendered->getHtmlBody());
        $this->assertSame($body2, $rendered->getBody());
    }
}
