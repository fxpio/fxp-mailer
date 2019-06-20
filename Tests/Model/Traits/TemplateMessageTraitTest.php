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

        static::assertNull($model->getName());
        $model->setName('NAME');
        static::assertSame('NAME', $model->getName());

        static::assertNull($model->getType());
        $model->setType('TYPE');
        static::assertSame('TYPE', $model->getType());

        static::assertTrue($model->isEnabled());
        $model->setEnabled(false);
        static::assertFalse($model->isEnabled());

        static::assertNull($model->getLabel());
        $model->setLabel('LABEL');
        static::assertSame('LABEL', $model->getLabel());

        static::assertNull($model->getDescription());
        $model->setDescription('DESCRIPTION');
        static::assertSame('DESCRIPTION', $model->getDescription());

        static::assertNull($model->getBody());
        $model->setBody('BODY');
        static::assertSame('BODY', $model->getBody());

        static::assertNull($model->getCreatedAt());
        $model->setCreatedAt(new \DateTime());
        static::assertInstanceOf(\DateTime::class, $model->getCreatedAt());

        static::assertNull($model->getUpdatedAt());
        $model->setUpdatedAt(new \DateTime());
        static::assertInstanceOf(\DateTime::class, $model->getUpdatedAt());
    }
}
