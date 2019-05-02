<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests;

use Fxp\Component\Mailer\Loader\MailLoaderInterface;
use Fxp\Component\Mailer\MailTemplater;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\Layout;
use Fxp\Component\Mailer\Model\LayoutTranslation;
use Fxp\Component\Mailer\Model\Mail;
use Fxp\Component\Mailer\Model\MailTranslation;
use Fxp\Component\Mailer\Model\TwigLayout;
use Fxp\Component\Mailer\Model\TwigLayoutTranslation;
use Fxp\Component\Mailer\Model\TwigMail;
use Fxp\Component\Mailer\Model\TwigMailTranslation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Template;
use Twig\TemplateWrapper;

/**
 * Tests for mail templater.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class MailTemplaterTest extends TestCase
{
    /**
     * @var MailLoaderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $loader;

    /**
     * @var Environment|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $twig;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|Template
     */
    protected $twigTemplate;

    /**
     * @var EventDispatcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dispatcher;

    /**
     * @var MailTemplater
     */
    protected $templater;

    protected function setUp(): void
    {
        $this->loader = $this->getMockBuilder(MailLoaderInterface::class)->getMock();
        $this->twig = $this->getMockBuilder(Environment::class)->disableOriginalConstructor()->getMock();
        $this->twigTemplate = $this->getMockBuilder(Template::class)->disableOriginalConstructor()->getMock();
        $this->dispatcher = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();
        $this->templater = new MailTemplater($this->loader, $this->twig, $this->dispatcher);
        $templateWrapper = new TemplateWrapper($this->twig, $this->twigTemplate);

        $this->twig->expects($this->any())
            ->method('createTemplate')
            ->will($this->returnValue($this->twigTemplate))
        ;

        $this->twig->expects($this->any())
            ->method('load')
            ->will($this->returnValue($templateWrapper))
        ;

        $this->twig->expects($this->any())
            ->method('mergeGlobals')
            ->willReturnCallback(function ($v) {
                return $v;
            })
        ;
    }

    public function testLocale(): void
    {
        $this->assertSame(\Locale::getDefault(), $this->templater->getLocale());

        $this->templater->setLocale('fr');
        $this->assertSame('fr', $this->templater->getLocale());
    }

    public function testRender(): void
    {
        $this->templater->setLocale('fr');

        $mail = $this->createMail(true, true);
        $trans = $mail->getTranslation('fr');
        $htmlRendered = $mail->getLayout()->getTranslation('fr')->getBody().' | '.$trans->getHtmlBody();
        $twigVariables = [
            '_mail_type' => MailTypes::TYPE_ALL,
            '_layout' => 'test',
        ];

        $this->assertNull($mail->getTranslationDomain());
        $this->assertCount(1, $mail->getTranslations());
        $this->assertNotNull($mail->getLayout());
        $this->assertNull($mail->getLayout()->getTranslationDomain());
        $this->assertCount(1, $mail->getLayout()->getTranslations());

        $this->loader->expects($this->once())
            ->method('load')
            ->with('test', MailTypes::TYPE_ALL)
            ->will($this->returnValue($mail))
        ;

        // render subject
        $this->twigTemplate->expects($this->at(0))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($trans->getSubject()))
        ;

        $twigVariables['_subject'] = $trans->getSubject();

        // render html body
        $this->twigTemplate->expects($this->at(1))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($trans->getHtmlBody()))
        ;

        $twigVariables['_html_body'] = $trans->getHtmlBody();

        // render body
        $this->twigTemplate->expects($this->at(2))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($trans->getBody()))
        ;

        $twigVariables['_body'] = $trans->getBody();

        // render layout
        $this->twigTemplate->expects($this->at(3))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($htmlRendered))
        ;

        $rendered = $this->templater->render('test', [], MailTypes::TYPE_ALL);

        $this->assertSame($trans->getSubject(), $rendered->getSubject());
        $this->assertSame($trans->getBody(), $rendered->getBody());
        $this->assertSame($htmlRendered, $rendered->getHtmlBody());
    }

    public function testRenderWithTranslator(): void
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|TranslatorInterface $translator */
        $translator = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $this->templater->setTranslator($translator);

        $this->templater->setLocale('fr');

        $mail = $this->createMail(true, false, true);
        $twigVariables = [
            '_mail_type' => MailTypes::TYPE_ALL,
            '_layout' => 'test',
        ];

        $this->assertSame('domain', $mail->getTranslationDomain());
        $this->assertCount(0, $mail->getTranslations());
        $this->assertNotNull($mail->getLayout());
        $this->assertSame('domain', $mail->getLayout()->getTranslationDomain());
        $this->assertCount(0, $mail->getLayout()->getTranslations());

        $this->loader->expects($this->once())
            ->method('load')
            ->with('test', MailTypes::TYPE_ALL)
            ->will($this->returnValue($mail))
        ;

        // translator mail
        $mailTransLabel = 'Test translated';
        $mailTransDescription = 'Description of translated template';
        $mailTransBody = 'Body of translated template';
        $mailTransSubject = 'Subject of translated template';
        $mailTransHtmlBody = 'HTML Body of translated template';

        $translator->expects($this->at(0))
            ->method('trans')
            ->with('Test', [], 'domain')
            ->will($this->returnValue($mailTransLabel))
        ;

        $translator->expects($this->at(1))
            ->method('trans')
            ->with('Description of template', [], 'domain')
            ->will($this->returnValue($mailTransDescription))
        ;

        $translator->expects($this->at(2))
            ->method('trans')
            ->with('Body of template', [], 'domain')
            ->will($this->returnValue($mailTransBody))
        ;

        $translator->expects($this->at(3))
            ->method('trans')
            ->with('Subject of template', [], 'domain')
            ->will($this->returnValue($mailTransSubject))
        ;

        $translator->expects($this->at(4))
            ->method('trans')
            ->with('HTML Body of template', [], 'domain')
            ->will($this->returnValue($mailTransHtmlBody))
        ;

        // translator layout
        $layoutTransLabel = 'Test translated';
        $layoutTransDescription = 'Description of translated template';
        $layoutTransBody = 'Body of translated template';

        $translator->expects($this->at(5))
            ->method('trans')
            ->with('Test', [], 'domain')
            ->will($this->returnValue($layoutTransLabel))
        ;

        $translator->expects($this->at(6))
            ->method('trans')
            ->with('Description of template', [], 'domain')
            ->will($this->returnValue($layoutTransDescription))
        ;

        $translator->expects($this->at(7))
            ->method('trans')
            ->with('Body of template', [], 'domain')
            ->will($this->returnValue($layoutTransBody))
        ;

        // render subject
        $this->twigTemplate->expects($this->at(0))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($mailTransSubject))
        ;

        $twigVariables['_subject'] = $mailTransSubject;

        // render html body
        $this->twigTemplate->expects($this->at(1))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($mailTransHtmlBody))
        ;

        $twigVariables['_html_body'] = $mailTransHtmlBody;

        // render body
        $this->twigTemplate->expects($this->at(2))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($mailTransBody))
        ;

        $twigVariables['_body'] = $mailTransBody;

        // render layout
        $htmlRendered = $layoutTransBody.' | '.$mailTransHtmlBody;

        $this->twigTemplate->expects($this->at(3))
            ->method('render')
            ->with($twigVariables)
            ->will($this->returnValue($htmlRendered))
        ;

        $rendered = $this->templater->render('test', [], MailTypes::TYPE_ALL);

        $this->assertSame($mailTransSubject, $rendered->getSubject());
        $this->assertSame($mailTransBody, $rendered->getBody());
        $this->assertSame($htmlRendered, $rendered->getHtmlBody());
    }

    public function testRenderWithTwig(): void
    {
        $this->templater->setLocale('fr');

        $layout = new TwigLayout(__DIR__.'/../Fixtures/loaders/layout.html.twig');
        $layout->setName('test');
        $layoutTrans = new TwigLayoutTranslation($layout, __DIR__.'/../Fixtures/loaders/layout.fr.html.twig');
        $layoutTrans->setLocale('fr');

        $mail = new TwigMail(__DIR__.'/../Fixtures/loaders/mail.html.twig');
        $mailTrans = new TwigMailTranslation($mail, __DIR__.'/../Fixtures/loaders/mail.fr.html.twig');
        $mailTrans->setLocale('fr');
        $mail->setLayout($layout);

        $trans = $mail->getTranslation('fr');
        $htmlRendered = $mail->getLayout()->getTranslation('fr')->getBody().' | '.$trans->getHtmlBody();
        $twigVariables = [
            '_mail_type' => MailTypes::TYPE_ALL,
            '_layout' => 'test',
        ];

        $this->assertNull($mail->getTranslationDomain());
        $this->assertCount(1, $mail->getTranslations());
        $this->assertNotNull($mail->getLayout());
        $this->assertNull($mail->getLayout()->getTranslationDomain());
        $this->assertCount(1, $mail->getLayout()->getTranslations());

        $this->loader->expects($this->once())
            ->method('load')
            ->with('test', MailTypes::TYPE_ALL)
            ->will($this->returnValue($mail))
        ;

        // render subject
        $this->twigTemplate->expects($this->at(0))
            ->method('displayBlock')
            ->with('subject', $twigVariables)
            ->willReturnCallback(function () use ($trans): void {
                echo $trans->getSubject();
            })
        ;

        $twigVariables['_subject'] = $trans->getSubject();

        // render html body
        $this->twigTemplate->expects($this->at(1))
            ->method('displayBlock')
            ->with('html_body', $twigVariables)
            ->willReturnCallback(function () use ($trans): void {
                echo $trans->getHtmlBody();
            })
        ;

        $twigVariables['_html_body'] = $trans->getHtmlBody();

        // render body
        $this->twigTemplate->expects($this->at(2))
            ->method('displayBlock')
            ->with('body', $twigVariables)
            ->willReturnCallback(function () use ($trans): void {
                echo $trans->getBody();
            })
        ;

        $twigVariables['_body'] = $trans->getBody();

        // render layout
        $this->twigTemplate->expects($this->at(3))
            ->method('displayBlock')
            ->with('body', $twigVariables)
            ->willReturnCallback(function () use ($htmlRendered): void {
                echo $htmlRendered;
            })
        ;

        $rendered = $this->templater->render('test', [], MailTypes::TYPE_ALL);

        $this->assertSame($trans->getSubject(), $rendered->getSubject());
        $this->assertSame($trans->getBody(), $rendered->getBody());
        $this->assertSame($htmlRendered, $rendered->getHtmlBody());
    }

    /**
     * Create the mail.
     *
     * @param bool $withLayout
     * @param bool $withTranslation
     * @param bool $withTranslationDomain
     *
     * @return Mail
     */
    protected function createMail($withLayout = false, $withTranslation = false, $withTranslationDomain = false)
    {
        $mail = new Mail();
        $mail
            ->setType(MailTypes::TYPE_ALL)
            ->setSubject('Subject of template')
            ->setHtmlBody('HTML Body of template')
            ->setBody('Body of template')
            ->setName('test')
            ->setLabel('Test')
            ->setDescription('Description of template')
            ->setEnabled(true)
            ->setTranslationDomain($withTranslationDomain ? 'domain' : null)
        ;

        if ($withLayout) {
            $mail->setLayout($this->createLayout($withTranslation, $withTranslationDomain));
        }

        if ($withTranslation && !$withTranslationDomain) {
            $translation = new MailTranslation($mail);
            $translation
                ->setSubject('Subject of translation')
                ->setHtmlBody('HTML body of translation')
                ->setLocale('fr')
                ->setLabel('Label of translation')
                ->setDescription('Description of translation')
                ->setBody('Body of translation')
            ;
        }

        return $mail;
    }

    /**
     * @param bool|false $withTranslation
     * @param bool|false $withTranslationDomain
     *
     * @return Layout
     */
    protected function createLayout($withTranslation = false, $withTranslationDomain = false)
    {
        $layout = new Layout();
        $layout
            ->setName('test')
            ->setLabel('Test')
            ->setDescription('Description of template')
            ->setEnabled(true)
            ->setBody('Body of template')
            ->setTranslationDomain($withTranslationDomain ? 'domain' : null)
        ;

        if ($withTranslation && !$withTranslationDomain) {
            $translation = new LayoutTranslation($layout);
            $translation
                ->setLocale('fr')
                ->setLabel('Label of translation')
                ->setDescription('Description of translation')
                ->setBody('Body of translation')
            ;
        }

        return $layout;
    }
}
