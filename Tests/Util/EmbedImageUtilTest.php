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

use Fxp\Component\Mailer\Util\EmbedImageUtil;
use PHPUnit\Framework\TestCase;

/**
 * Tests for util of swiftmailer embed image.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EmbedImageUtilTest extends TestCase
{
    public function getLocalePathData()
    {
        $webDir = __DIR__.'/../Fixtures';

        return [
            ['http://www.example.tld/loaders/mail.yml', $webDir, '/(.*)+/', realpath($webDir.'/loaders/mail.yml')],
            ['http://www.example.tld/loaders/mail.yml', $webDir, '/(.*)+.example.tld$/', realpath($webDir.'/loaders/mail.yml')],
            ['http://www.example.tld/loaders/mail.yml', $webDir, '/^example.tld$/', 'http://www.example.tld/loaders/mail.yml'],
            ['./loaders/mail.yml', $webDir, '/(.*)+.example.tld$/', realpath($webDir.'/loaders/mail.yml')],
            ['loaders/mail.yml', $webDir, '/(.*)+.example.tld$/', realpath($webDir.'/loaders/mail.yml')],
            ['/loaders/mail.yml', $webDir, '/(.*)+.example.tld$/', realpath($webDir.'/loaders/mail.yml')],
            ['http://www.example.tld/loaders/mail.yml', $webDir, '/^((.*)+\.)?example.tld$/', realpath($webDir.'/loaders/mail.yml')],
            ['http://example.tld/loaders/mail.yml', $webDir, '/^((.*)+\.)?example.tld$/', realpath($webDir.'/loaders/mail.yml')],
        ];
    }

    /**
     * @dataProvider getLocalePathData
     *
     * @param string $path
     * @param string $webDir
     * @param string $hostPattern
     * @param string $valid
     */
    public function testGetLocalPath($path, $webDir, $hostPattern, $valid)
    {
        $this->assertSame($valid, EmbedImageUtil::getLocalPath($path, $webDir, $hostPattern));
    }
}
