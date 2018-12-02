<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Filter\Template;

use Fxp\Component\Mailer\Filter\Template\CssToStylesFilter;
use Fxp\Component\Mailer\MailRenderedInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\MailInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for css to styles filter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class CssToStylesFilterTest extends TestCase
{
    public function getSupportTests()
    {
        return [
            [MailTypes::TYPE_ALL,    true],
            [MailTypes::TYPE_SCREEN, true],
            [MailTypes::TYPE_PRINT,  false],
        ];
    }

    /**
     * @dataProvider getSupportTests
     *
     * @param string $type      The mail type
     * @param bool   $supported Check if the mail type is supported
     */
    public function testSupports($type, $supported)
    {
        /* @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mailRendered */
        $mailRendered = $this->getMockBuilder(MailRenderedInterface::class)->getMock();
        $mailRendered->expects($this->once())
            ->method('getTemplate')
            ->will($this->returnCallback(function () use ($type) {
                $template = $this->getMockBuilder(MailInterface::class)->getMock();
                $template->expects($this->once())
                    ->method('getType')
                    ->will($this->returnValue($type));

                return $template;
            }));

        $filter = new CssToStylesFilter();

        $this->assertSame($supported, $filter->supports($mailRendered));
    }

    public function testFilter()
    {
        if (\defined('HHVM_VERSION')) {
            $this->markTestSkipped('Bug: CssToInlineStyles::inlineCssOnElement() return a boolean on HHVM');

            return;
        }

        $html = '<html><head><style>p {color: #f7f7f7;}</style></head><body><p>Test.</p></body></html>';
        $htmlConverted = '<html><head><style>p {color: #f7f7f7;}</style></head><body><p style="color: #f7f7f7;">Test.</p></body></html>';
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->loadHTML(mb_convert_encoding($htmlConverted, 'HTML-ENTITIES', 'UTF-8'));
        $document->formatOutput = true;
        $htmlConverted = trim($document->saveHTML($document));

        /* @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mailRendered */
        $mailRendered = $this->getMockBuilder(MailRenderedInterface::class)->getMock();
        $mailRendered->expects($this->at(0))
            ->method('getHtmlBody')
            ->will($this->returnValue($html));

        $mailRendered->expects($this->once())
            ->method('setHtmlBody')
            ->with($htmlConverted);

        $mailRendered->expects($this->at(2))
            ->method('getHtmlBody')
            ->will($this->returnValue($htmlConverted));

        $filter = new CssToStylesFilter();
        $filter->filter($mailRendered);

        $this->assertSame($htmlConverted, $mailRendered->getHtmlBody());
    }
}
