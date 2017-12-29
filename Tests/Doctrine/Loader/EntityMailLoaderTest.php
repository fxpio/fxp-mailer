<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Doctrine\Loader;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Fxp\Component\Mailer\Doctrine\Loader\EntityMailLoader;
use Fxp\Component\Mailer\Entity\Mail;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Util\MailUtil;
use PHPUnit\Framework\TestCase;

/**
 * Tests for entity mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class EntityMailLoaderTest extends TestCase
{
    /**
     * @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $om;

    /**
     * @var ObjectRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $repo;

    /**
     * @var EntityMailLoader
     */
    protected $loader;

    protected function setUp()
    {
        $class = Mail::class;

        $this->repo = $this->getMockBuilder(ObjectRepository::class)->getMock();

        $this->om = $this->getMockBuilder(ObjectManager::class)->getMock();
        $this->om->expects($this->once())
            ->method('getRepository')
            ->with($class)
            ->will($this->returnValue($this->repo))
        ;

        /* @var ManagerRegistry|\PHPUnit_Framework_MockObject_MockObject $registry */
        $registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();
        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->with($class)
            ->will($this->returnValue($this->om))
        ;

        $this->loader = new EntityMailLoader($registry, $class);
    }

    public function testLoad()
    {
        $template = $this->getMockBuilder(Mail::class)->disableOriginalConstructor()->getMock();
        $this->repo->expects($this->once())
            ->method('findOneBy')
            ->with(array(
                'name' => 'test',
                'enabled' => true,
                'type' => MailUtil::getValidTypes(MailTypes::TYPE_ALL),
            ))
            ->will($this->returnValue($template))
        ;

        $this->assertSame($template, $this->loader->load('test'));
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\UnknownMailException
     * @expectedExceptionMessage The "test" mail template does not exist with the "all" type
     */
    public function testLoadUnknownTemplate()
    {
        $this->loader->load('test');
    }
}
