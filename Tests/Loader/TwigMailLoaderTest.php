<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\MailerBundle\Tests\Loader;

use Sonatra\Bundle\MailerBundle\Exception\UnknownMailException;
use Sonatra\Bundle\MailerBundle\Loader\LayoutLoaderInterface;
use Sonatra\Bundle\MailerBundle\Loader\TwigMailLoader;
use Sonatra\Bundle\MailerBundle\Model\LayoutInterface;
use Sonatra\Bundle\MailerBundle\Model\MailInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Tests for twig mail loader.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TwigMailLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        // layout
        $templateLayout = $this->getMock(LayoutInterface::class);
        $templateLayout->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('test'));
        $templateLayout->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        // loader
        /* @var LayoutLoaderInterface|\PHPUnit_Framework_MockObject_MockObject $layoutLoader */
        $layoutLoader = $this->getMock(LayoutLoaderInterface::class);
        $layoutLoader->expects($this->once())
            ->method('load')
            ->will($this->returnValue($templateLayout));

        /* @var KernelInterface|\PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMock(KernelInterface::class);
        $template = array(
            'name' => 'test',
            'layout' => 'test',
            'file' => '@AcmeDemoBundle/Resources/loaders/mail.html.twig',
            'translations' => array(
                array(
                    'locale' => 'fr',
                    'file' => '@AcmeDemoBundle/Resources/loaders/mail.fr.html.twig',
                ),
            ),
        );

        $kernel->expects($this->at(0))
            ->method('locateResource')
            ->with('@AcmeDemoBundle/Resources/loaders/mail.html.twig')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/mail.html.twig'));

        $kernel->expects($this->at(1))
            ->method('locateResource')
            ->with('@AcmeDemoBundle/Resources/loaders/mail.fr.html.twig')
            ->will($this->returnValue(__DIR__.'/../Fixtures/loaders/mail.fr.html.twig'));

        $loader = new TwigMailLoader(array($template), $layoutLoader, $kernel);

        $this->assertInstanceOf(MailInterface::class, $loader->load('test'));
    }

    public function testLoadUnknownTemplate()
    {
        $this->setExpectedException(UnknownMailException::class, 'The "test" mail template does not exist with the "all" type');
        /* @var LayoutLoaderInterface $layoutLoader */
        $layoutLoader = $this->getMock(LayoutLoaderInterface::class);
        /* @var KernelInterface $kernel */
        $kernel = $this->getMock(KernelInterface::class);

        $loader = new TwigMailLoader(array(), $layoutLoader, $kernel);

        $loader->load('test');
    }
}
