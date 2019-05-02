<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Event;

use Fxp\Component\Mailer\Event\FilterPostRenderEvent;
use Fxp\Component\Mailer\MailRenderedInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for filter post render event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class FilterPostRenderEventTest extends TestCase
{
    public function testModel(): void
    {
        /** @var MailRenderedInterface $mailRendered */
        $mailRendered = $this->getMockBuilder(MailRenderedInterface::class)->getMock();
        $event = new FilterPostRenderEvent($mailRendered);

        $this->assertSame($mailRendered, $event->getMailRendered());
    }
}
