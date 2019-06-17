<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Doctrine\Repository\Traits;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Fxp\Component\Mailer\Doctrine\Repository\Traits\TemplateMessageRepositoryTrait;
use Fxp\Component\Mailer\Tests\Fixtures\Mock\TemplateMessage;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TemplateMessageRepositoryTraitTest extends TestCase
{
    /**
     * @throws
     */
    public function testFindTemplate(): void
    {
        $expectedTemplateMessage = new TemplateMessage();

        $query = $this->getMockForAbstractClass(AbstractQuery::class, [], '', false, false, true, [
            'setHint',
            'getOneOrNullResult',
        ]);

        $query->expects($this->at(0))
            ->method('setHint')
            ->with(Query::HINT_CUSTOM_OUTPUT_WALKER, TranslationWalker::class)
        ;
        $query->expects($this->at(1))
            ->method('setHint')
            ->with(TranslatableListener::HINT_TRANSLATABLE_LOCALE, 'fr_FR')
        ;
        $query->expects($this->at(2))
            ->method('setHint')
            ->with(TranslatableListener::HINT_FALLBACK, 1)
        ;

        $query->expects($this->once())
            ->method('getOneOrNullResult')
            ->willReturn($expectedTemplateMessage)
        ;

        $qb = $this->getMockBuilder(QueryBuilder::class)->disableOriginalConstructor()->getMock();

        $qb->expects($this->at(0))
            ->method('where')
            ->with('t.name = :name')
            ->willReturn($qb)
        ;
        $qb->expects($this->at(1))
            ->method('andWhere')
            ->with('t.enabled = true')
            ->willReturn($qb)
        ;
        $qb->expects($this->at(2))
            ->method('setParameter')
            ->with('name', 'template_name')
            ->willReturn($qb)
        ;
        $qb->expects($this->at(3))
            ->method('andWhere')
            ->with('t.type = :type')
            ->willReturn($qb)
        ;
        $qb->expects($this->at(4))
            ->method('setParameter')
            ->with('type', 'template_type')
            ->willReturn($qb)
        ;
        $qb->expects($this->at(5))
            ->method('getQuery')
            ->willReturn($query)
        ;

        /** @var MockObject|TemplateMessageRepositoryTrait $trait */
        $trait = $this->getMockForTrait(TemplateMessageRepositoryTrait::class, [], '', false, false, true, [
            'createQueryBuilder',
            'getClassName',
        ]);

        $trait->expects($this->once())
            ->method('createQueryBuilder')
            ->with('t')
            ->willReturn($qb)
        ;

        $trait->expects($this->once())
            ->method('getClassName')
            ->willReturn(TemplateMessage::class)
        ;

        $res = $trait->findTemplate('template_name', 'template_type', 'fr_FR');

        $this->assertSame($expectedTemplateMessage, $res);
    }
}
