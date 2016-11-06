<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Tests\Util;

use Sonatra\Component\Mailer\Util\ConfigUtil;

/**
 * Tests for config util.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ConfigUtilTest extends \PHPUnit_Framework_TestCase
{
    public function testFormatConfigWithString()
    {
        $config = 'filename.file';

        $valid = array(
            'file' => $config,
        );

        $this->assertEquals($valid, ConfigUtil::formatConfig($config));
    }

    /**
     * @expectedException \Sonatra\Component\Mailer\Exception\UnexpectedTypeException
     * @expectedExceptionMessage Expected argument of type "array", "integer" given
     */
    public function testFormatConfigWithoutFile()
    {
        $config = 42;

        ConfigUtil::formatConfig($config);
    }

    /**
     * @expectedException \Sonatra\Component\Mailer\Exception\InvalidConfigurationException
     * @expectedExceptionMessage The "file" attribute must be defined in config of layout template
     */
    public function testFormatConfigWithInvalidFilename()
    {
        $config = array(
            'name' => 'test',
        );

        ConfigUtil::formatConfig($config);
    }
}
