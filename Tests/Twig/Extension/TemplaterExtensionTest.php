<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Twig\Extension;

use Fxp\Component\Mailer\Loader\TemplateLayoutLoaderInterface;
use Fxp\Component\Mailer\MailRenderedInterface;
use Fxp\Component\Mailer\MailTemplaterInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use Fxp\Component\Mailer\Model\TwigTemplateLayout;
use Fxp\Component\Mailer\Twig\Extension\TemplaterExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;
use Twig\TwigFunction;

/**
 * Tests for twig templater extension.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplaterExtensionTest extends TestCase
{
    /**
     * @var MailTemplaterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $templater;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TemplateLayoutLoaderInterface
     */
    protected $layoutLoader;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TranslatorInterface
     */
    protected $translator;

    /**
     * @var TemplaterExtension
     */
    protected $ext;

    protected function setUp(): void
    {
        $this->templater = $this->getMockBuilder(MailTemplaterInterface::class)->getMock();
        $this->layoutLoader = $this->getMockBuilder(TemplateLayoutLoaderInterface::class)->getMock();
        $this->translator = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $this->ext = new TemplaterExtension($this->layoutLoader, $this->translator);

        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $container->expects($this->any())
            ->method('get')
            ->with('fxp_mailer.mail_templater')
            ->will($this->returnValue($this->templater))
        ;

        $this->ext->container = $container;
    }

    public function testBasic(): void
    {
        $this->assertCount(5, $this->ext->getFunctions());

        $valid = [
            'fxp_mailer_render_subject',
            'fxp_mailer_render_html',
            'fxp_mailer_render_text',
            'fxp_mailer_mail_rendered',
            'fxp_mailer_clean',
        ];

        /** @var TwigFunction $function */
        foreach ($this->ext->getFunctions() as $function) {
            $this->assertInstanceOf(TwigFunction::class, $function);
            $this->assertTrue(\in_array($function->getName(), $valid, true));
        }

        $this->assertCount(1, $this->ext->getTokenParsers());
    }

    public function testGetMailRendered(): void
    {
        /** @var string $template */
        /** @var array $variables */
        /** @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();

        $rendered = $this->ext->getMailRendered($template, $variables);

        $this->assertSame($mail, $rendered);
    }

    public function testGetMailRenderedCache(): void
    {
        /** @var string $template */
        /** @var array $variables */
        /** @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig(true);

        $rendered = $this->ext->getMailRendered($template, $variables);

        $this->assertSame($mail, $rendered);

        $rendered2 = $this->ext->getMailRendered($template, $variables);

        $this->assertSame($rendered, $rendered2);

        $this->ext->cleanRendered($template);

        $rendered3 = $this->ext->getMailRendered($template, $variables);

        $this->assertNotSame($rendered, $rendered3);
    }

    public function testRenderSubject(): void
    {
        /** @var string $template */
        /** @var array $variables */
        /** @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();
        $validSubject = 'Subject';

        $mail->expects($this->at(0))
            ->method('getSubject')
            ->with()
            ->will($this->returnValue($validSubject))
        ;

        $subject = $this->ext->renderSubject($template, $variables);

        $this->assertSame($validSubject, $subject);
    }

    public function testRenderHtml(): void
    {
        /** @var string $template */
        /** @var array $variables */
        /** @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();
        $validHtml = '<p>Foo bar.</p>';

        $mail->expects($this->at(0))
            ->method('getHtmlBody')
            ->with()
            ->will($this->returnValue($validHtml))
        ;

        $html = $this->ext->renderHtml($template, $variables);

        $this->assertSame($validHtml, $html);
    }

    public function testRenderPlainText(): void
    {
        /** @var string $template */
        /** @var array $variables */
        /** @var MailRenderedInterface|\PHPUnit_Framework_MockObject_MockObject $mail */
        list($template, $variables, $mail) = $this->getConfig();
        $validPlainText = 'Foo bar.';

        $mail->expects($this->at(0))
            ->method('getBody')
            ->with()
            ->will($this->returnValue($validPlainText))
        ;

        $plainText = $this->ext->renderPlainText($template, $variables);

        $this->assertSame($validPlainText, $plainText);
    }

    public function testGetTranslatedLayout(): void
    {
        $layout = $this->getMockBuilder(TwigTemplateLayout::class)->disableOriginalConstructor()->getMock();

        $layout->expects($this->once())
            ->method('getTranslation')
            ->will($this->returnValue(clone $layout))
        ;

        $this->templater->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue('fr'))
        ;

        $this->layoutLoader->expects($this->once())
            ->method('load')
            ->with('test')
            ->will($this->returnValue($layout))
        ;

        $res = $this->ext->getTranslatedLayout('test');

        $this->assertInstanceOf(TwigTemplateLayout::class, $res);
        $this->assertNotSame($layout, $res);
    }

    public function testGetTranslatedLayoutWithInvalidLayout(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "test" layout is not a twig layout');

        $layout = $this->getMockBuilder(TemplateLayoutInterface::class)->getMock();

        $layout->expects($this->once())
            ->method('getTranslation')
            ->will($this->returnValue(clone $layout))
        ;

        $this->templater->expects($this->once())
            ->method('getLocale')
            ->will($this->returnValue('fr'))
        ;

        $this->layoutLoader->expects($this->once())
            ->method('load')
            ->with('test')
            ->will($this->returnValue($layout))
        ;

        $this->ext->getTranslatedLayout('test');
    }

    /**
     * @param bool $clone
     *
     * @return array
     */
    public function getConfig($clone = false)
    {
        $template = 'test';
        $variables = [
            'foo' => 'bar',
        ];

        $mail = $this->getMockBuilder(MailRenderedInterface::class)->getMock();

        $this->templater->expects($this->at(0))
            ->method('render')
            ->with($template, $variables, MailTypes::TYPE_ALL)
            ->will($this->returnValue($mail))
        ;

        if ($clone) {
            $this->templater->expects($this->at(1))
                ->method('render')
                ->with($template, $variables, MailTypes::TYPE_ALL)
                ->will($this->returnValue(clone $mail))
            ;
        }

        return [$template, $variables, $mail];
    }

    public function testLayoutTokenParser(): void
    {
        $loader = new FilesystemLoader(__DIR__.'/../../Fixtures/token_parsers');
        $twig = new Environment($loader, ['debug' => true, 'cache' => false]);
        $twig->addExtension($this->ext);

        $this->assertInstanceOf(TemplateWrapper::class, $twig->load('mail.html.twig'));
    }
}
