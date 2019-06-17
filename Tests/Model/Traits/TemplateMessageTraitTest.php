<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Model\Traits;

use Fxp\Component\Mailer\Model\Traits\TemplateMessageTrait;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateMessageTraitTest extends TestCase
{
    /**
     * @throws
     */
    public function testGetterSetter(): void
    {
        $model = $this->getMockForTrait(TemplateMessageTrait::class);

        $this->assertNull($model->getName());
        $model->setName('NAME');
        $this->assertSame('NAME', $model->getName());

        $this->assertNull($model->getType());
        $model->setType('TYPE');
        $this->assertSame('TYPE', $model->getType());

        $this->assertTrue($model->isEnabled());
        $model->setEnabled(false);
        $this->assertFalse($model->isEnabled());

        $this->assertNull($model->getLabel());
        $model->setLabel('LABEL');
        $this->assertSame('LABEL', $model->getLabel());

        $this->assertNull($model->getDescription());
        $model->setDescription('DESCRIPTION');
        $this->assertSame('DESCRIPTION', $model->getDescription());

        $this->assertNull($model->getBody());
        $model->setBody('BODY');
        $this->assertSame('BODY', $model->getBody());

        $this->assertNull($model->getCreatedAt());
        $model->setCreatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $model->getCreatedAt());

        $this->assertNull($model->getUpdatedAt());
        $model->setUpdatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $model->getUpdatedAt());
    }
}
