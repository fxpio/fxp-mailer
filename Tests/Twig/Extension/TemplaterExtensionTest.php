<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\MailerBundle\Tests\Twig\Extension;

use Sonatra\Bundle\MailerBundle\Exception\InvalidArgumentException;
use Sonatra\Bundle\MailerBundle\Loader\LayoutLoaderInterface;
use Sonatra\Bundle\MailerBundle\Mailer\MailRenderedInterface;
use Sonatra\Bundle\MailerBundle\Mailer\MailTemplaterInterface;
use Sonatra\Bundle\MailerBundle\MailTypes;
use Sonatra\Bundle\MailerBundle\Model\LayoutInterface;
use Sonatra\Bundle\MailerBundle\Model\TwigLayout;
use Sonatra\Bundle\MailerBundle\Twig\Extension\TemplaterExtension;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Tests for twig templater extension.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TemplaterExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MailTemplaterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $templater;

    /**
     * @var LayoutLoaderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $layoutLoader;

    /**
     * @var TranslatorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $translator;

    /**
     * @var TemplaterExtension
     */
    protected $ext;

    protected function setUp()
    {
        $this->templater = $this->getMock(MailTemplaterInterface::class);
        $this->layoutLoader = $this->getMock(LayoutLoaderInterface::class);
        $this->translator = $this->getMock(TranslatorInterface::class);
        $this->ext = new TemplaterExtension($this->templater, $this->layoutLoader, $this->translator);
    }

    public function testBasic()
    {
        $this->assertSame('sonatra_mailer_templater', $this->ext->getName());
        $this->assertCount(3, $this->ext->getFunctions());

        $valid = array(
            'sonatra_mailer_render',
            'sonatra_mailer_render_plain',
            'sonatra_mailer_mail_rendered',
        );

        /* @var \Twig_SimpleFunction $function */
        foreach ($this->ext->getFunctions() as $function) {
            $this->assertInstanceOf(\Twig_SimpleFunction::class, $function);
            $this->assertTrue(in_array($function->getName(), $valid));
        }

        $this->assertCount(1, $this->ext->getTokenParsers());
    }

    public function testGetMailRendered()
    {
        /* @var string $template */
        /* @var array $variables */
        /* @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();

        $rendered = $this->ext->getMailRendered($template, $variables);

        $this->assertSame($mail, $rendered);
    }

    public function testRenderHtml()
    {
        /* @var string $template */
        /* @var array $variables */
        /* @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();
        $validHtml = '<p>Foo bar.</p>';

        $mail->expects($this->at(0))
            ->method('getHtmlBody')
            ->with()
            ->will($this->returnValue($validHtml));

        $html = $this->ext->renderHtml($template, $variables);

        $this->assertSame($validHtml, $html);
    }

    public function testRenderPlainText()
    {
        /* @var string $template */
        /* @var array $variables */
        /* @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();
        $validPlainText = 'Foo bar.';

        $mail->expects($this->at(0))
            ->method('getBody')
            ->with()
            ->will($this->returnValue($validPlainText));

        $plainText = $this->ext->renderPlainText($template, $variables);

        $this->assertSame($validPlainText, $plainText);
    }

    public function testGetTranslatedLayout()
    {
        $layout = $this->getMockBuilder(TwigLayout::class)->disableOriginalConstructor()->getMock();

        $layout->expects($this->once())
            ->method('getTranslation')
            ->will($this->returnValue(clone $layout));

        $this->templater->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue('fr'));

        $this->layoutLoader->expects($this->once())
            ->method('load')
            ->with('test')
            ->will($this->returnValue($layout));

        $res = $this->ext->getTranslatedLayout('test');

        $this->assertInstanceOf(TwigLayout::class, $res);
        $this->assertNotSame($layout, $res);
    }

    public function testGetTranslatedLayoutWithInvalidLayout()
    {
        $msg = 'The "test" layout is not a twig layout';
        $this->setExpectedException(InvalidArgumentException::class, $msg);

        $layout = $this->getMock(LayoutInterface::class);

        $layout->expects($this->once())
            ->method('getTranslation')
            ->will($this->returnValue(clone $layout));

        $this->templater->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue('fr'));

        $this->layoutLoader->expects($this->once())
            ->method('load')
            ->with('test')
            ->will($this->returnValue($layout));

        $this->ext->getTranslatedLayout('test');
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $template = 'test';
        $variables = array(
            'foo' => 'bar',
        );

        $mail = $this->getMock(MailRenderedInterface::class);

        $this->templater->expects($this->once())
            ->method('render')
            ->with($template, $variables, MailTypes::TYPE_ALL)
            ->will($this->returnValue($mail));

        return array($template, $variables, $mail);
    }
}
