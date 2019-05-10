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
use Fxp\Component\Mailer\Doctrine\Loader\EntityTemplateLayoutLoader;
use Fxp\Component\Mailer\Entity\TemplateLayout;
use PHPUnit\Framework\TestCase;

/**
 * Tests for entity template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class EntityTemplateLayoutLoaderTest extends TestCase
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
     * @var EntityTemplateLayoutLoader
     */
    protected $loader;

    protected function setUp(): void
    {
        $class = TemplateLayout::class;

        $this->repo = $this->getMockBuilder(ObjectRepository::class)->getMock();

        $this->om = $this->getMockBuilder(ObjectManager::class)->getMock();
        $this->om->expects($this->once())
            ->method('getRepository')
            ->with($class)
            ->will($this->returnValue($this->repo))
        ;

        /** @var ManagerRegistry|\PHPUnit_Framework_MockObject_MockObject $registry */
        $registry = $this->getMockBuilder(ManagerRegistry::class)->getMock();
        $registry->expects($this->once())
            ->method('getManagerForClass')
            ->with($class)
            ->will($this->returnValue($this->om))
        ;

        $this->loader = new EntityTemplateLayoutLoader($registry, $class);
    }

    public function testLoad(): void
    {
        $template = $this->getMockBuilder(TemplateLayout::class)->disableOriginalConstructor()->getMock();
        $this->repo->expects($this->once())
            ->method('findOneBy')
            ->with([
                'name' => 'test',
                'enabled' => true,
            ])
            ->will($this->returnValue($template))
        ;

        $this->assertSame($template, $this->loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        $this->loader->load('test');
    }
}
