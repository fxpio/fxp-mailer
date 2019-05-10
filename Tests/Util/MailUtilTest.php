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

use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\TemplateMailInterface;
use Fxp\Component\Mailer\Util\MailUtil;
use PHPUnit\Framework\TestCase;

/**
 * Tests for util mail.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class MailUtilTest extends TestCase
{
    public function getCheckIsValidMailTypes()
    {
        return [
            [true,  MailTypes::TYPE_ALL,    true,  MailTypes::TYPE_ALL],
            [true,  MailTypes::TYPE_ALL,    true,  MailTypes::TYPE_PRINT],
            [true,  MailTypes::TYPE_ALL,    true,  MailTypes::TYPE_SCREEN],
            [true,  MailTypes::TYPE_PRINT,  true,  MailTypes::TYPE_ALL],
            [true,  MailTypes::TYPE_PRINT,  true,  MailTypes::TYPE_PRINT],
            [false, MailTypes::TYPE_PRINT,  true,  MailTypes::TYPE_SCREEN],
            [true,  MailTypes::TYPE_SCREEN, true,  MailTypes::TYPE_ALL],
            [false, MailTypes::TYPE_SCREEN, true,  MailTypes::TYPE_PRINT],
            [true,  MailTypes::TYPE_SCREEN, true,  MailTypes::TYPE_SCREEN],

            [false, MailTypes::TYPE_ALL,    false, MailTypes::TYPE_ALL],
            [false, MailTypes::TYPE_ALL,    false, MailTypes::TYPE_PRINT],
            [false, MailTypes::TYPE_ALL,    false, MailTypes::TYPE_SCREEN],
            [false, MailTypes::TYPE_PRINT,  false, MailTypes::TYPE_ALL],
            [false, MailTypes::TYPE_PRINT,  false, MailTypes::TYPE_PRINT],
            [false, MailTypes::TYPE_PRINT,  false, MailTypes::TYPE_SCREEN],
            [false, MailTypes::TYPE_SCREEN, false, MailTypes::TYPE_ALL],
            [false, MailTypes::TYPE_SCREEN, false, MailTypes::TYPE_PRINT],
            [false, MailTypes::TYPE_SCREEN, false, MailTypes::TYPE_SCREEN],
        ];
    }

    /**
     * @dataProvider getCheckIsValidMailTypes
     *
     * @param bool   $result      The result value
     * @param string $entryType   The entry type
     * @param bool   $mailEnabled The value of mail field 'enabled'
     * @param string $mailType    The value of mail field 'type'
     */
    public function testIsValid($result, $entryType, $mailEnabled, $mailType): void
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|TemplateMailInterface $mail */
        $mail = $this->getMockBuilder(TemplateMailInterface::class)->getMock();
        $mail->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue($mailEnabled))
        ;
        $mail->expects($this->any())
            ->method('getType')
            ->will($this->returnValue($mailType))
        ;

        $this->assertSame($result, MailUtil::isValid($mail, $entryType));
    }

    public function getTypes()
    {
        return [
            [MailTypes::TYPE_ALL,    [MailTypes::TYPE_ALL, MailTypes::TYPE_PRINT, MailTypes::TYPE_SCREEN]],
            [MailTypes::TYPE_PRINT,  [MailTypes::TYPE_ALL, MailTypes::TYPE_PRINT]],
            [MailTypes::TYPE_SCREEN, [MailTypes::TYPE_ALL, MailTypes::TYPE_SCREEN]],
            ['invalid',              [MailTypes::TYPE_ALL, MailTypes::TYPE_PRINT, MailTypes::TYPE_SCREEN]],
        ];
    }

    /**
     * @dataProvider getTypes
     *
     * @param string   $type       The entry type
     * @param string[] $validTypes The valid types for entry
     */
    public function testGetValidTypes($type, $validTypes): void
    {
        $this->assertEquals($validTypes, MailUtil::getValidTypes($type));
    }
}
