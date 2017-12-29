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
 */
class ConfigUtilTest extends TestCase
{
    public function testFormatConfigWithString()
    {
        $config = 'filename.file';

        $valid = [
            'file' => $config,
        ];

        $this->assertEquals($valid, ConfigUtil::formatConfig($config));
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\UnexpectedTypeException
     * @expectedExceptionMessage Expected argument of type "array", "integer" given
     */
    public function testFormatConfigWithoutFile()
    {
        $config = 42;

        ConfigUtil::formatConfig($config);
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The "file" attribute must be defined in config of layout template
     */
    public function testFormatConfigWithInvalidFilename()
    {
        $config = [
            'name' => 'test',
        ];

        ConfigUtil::formatConfig($config);
    }
}
