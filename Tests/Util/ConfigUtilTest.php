<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Util;

use Fxp\Component\Mailer\Util\ConfigUtil;
use PHPUnit\Framework\TestCase;

/**
 * Tests for config util.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ConfigUtilTest extends TestCase
{
    public function testFormatConfigWithString(): void
    {
        $config = 'filename.file';

        $valid = [
            'file' => $config,
        ];

        $this->assertEquals($valid, ConfigUtil::formatConfig($config));
    }

    public function testFormatConfigWithoutFile(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "array", "integer" given');

        $config = 42;

        ConfigUtil::formatConfig($config);
    }

    public function testFormatConfigWithInvalidFilename(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\InvalidConfigurationException::class);
        $this->expectExceptionMessage('The "file" attribute must be defined in config of layout template');

        $config = [
            'name' => 'test',
        ];

        ConfigUtil::formatConfig($config);
    }
}
