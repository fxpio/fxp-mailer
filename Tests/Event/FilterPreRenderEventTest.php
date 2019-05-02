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

use Fxp\Component\Mailer\Event\FilterPreRenderEvent;
use Fxp\Component\Mailer\MailTypes;
use PHPUnit\Framework\TestCase;

/**
 * Tests for filter pre render event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class FilterPreRenderEventTest extends TestCase
{
    public function testModel(): void
    {
        $template = 'template_name';
        $variables = ['foo' => 'bar'];
        $type = MailTypes::TYPE_ALL;

        $event = new FilterPreRenderEvent($template, $variables, $type);

        $this->assertSame($template, $event->getTemplate());
        $this->assertSame($variables, $event->getVariables());
        $this->assertSame($type, $event->getType());

        $template2 = 'new_template_name';
        $variables2 = array_merge($variables, ['bar' => 'foo']);
        $type2 = MailTypes::TYPE_SCREEN;

        $event->setTemplate($template2);
        $event->setVariables($variables2);
        $event->setType($type2);

        $this->assertSame($template2, $event->getTemplate());
        $this->assertSame($variables2, $event->getVariables());
        $this->assertSame($type2, $event->getType());
    }
}
