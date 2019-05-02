<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Loader;

use Fxp\Component\Mailer\Loader\ConfigMailLoader;
use Fxp\Component\Mailer\Loader\LayoutLoaderInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\LayoutInterface;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for config mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ConfigMailLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        // layout
        $templateLayout = $this->getMockBuilder(LayoutInterface::class)->getMock();
        $templateLayout->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'))
        ;
        $templateLayout->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true))
        ;

        // mail
        $template = [
            'name' => 'test',
            'label' => 'Test',
            'description' => 'Description of test',
            'type' => MailTypes::TYPE_ALL,
            'enabled' => true,
            'subject' => 'Subject of mail with {{ twig_variable }}',
            'html_body' => '<p>HTML content of mail with {{ twig_variable }}.</p>',
            'body' => 'Content of mail with {{ twig_variable }}.',
            'layout' => 'test',
            'translations' => [
                [
                    'locale' => 'fr',
                    'label' => 'Test fr',
                    'description' => 'Description du test',
                    'subject' => 'Sujet du courrier avec {{ twig_variable }}',
                    'html_body' => '<p>Contenu HTML du courrier avec {{ twig_variable }}.</p>',
                    'body' => 'Contenu du courrier avec {{ twig_variable }}.',
                ],
            ],
        ];

        /** @var LayoutLoaderInterface|\PHPUnit_Framework_MockObject_MockObject $layoutLoader */
        $layoutLoader = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();
        $layoutLoader->expects($this->once())
            ->method('load')
            ->will($this->returnValue($templateLayout))
        ;

        $loader = new ConfigMailLoader([$template], $layoutLoader);

        $mail = $loader->load('test');

        $this->assertInstanceOf(MailInterface::class, $mail);
        $this->assertInstanceOf(LayoutInterface::class, $mail->getLayout());
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownMailException::class);
        $this->expectExceptionMessage('The "test" mail template does not exist with the "all" type');

        /** @var LayoutLoaderInterface $layoutLoader */
        $layoutLoader = $this->getMockBuilder(LayoutLoaderInterface::class)->getMock();

        $loader = new ConfigMailLoader([], $layoutLoader);

        $loader->load('test');
    }
}
