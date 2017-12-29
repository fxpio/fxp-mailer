<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Model;

use Fxp\Component\Mailer\Model\AbstractTemplate;
use Fxp\Component\Mailer\Model\TemplateInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for abstract template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class AbstractTemplateTest extends TestCase
{
    public function testModel()
    {
        /* @var TemplateInterface $template */
        $template = $this->getMockForAbstractClass(AbstractTemplate::class);
        $template
            ->setName('test')
            ->setLabel('Test')
            ->setDescription('Description of template')
            ->setEnabled(true)
            ->setBody('Body of template')
        ;

        $this->assertSame('test', $template->getName());
        $this->assertSame('Test', $template->getLabel());
        $this->assertSame('Description of template', $template->getDescription());
        $this->assertTrue($template->isEnabled());
        $this->assertSame('Body of template', $template->getBody());
    }
}
