<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Filter;

use Fxp\Component\Mailer\Filter\FilterRegistry;
use Fxp\Component\Mailer\Filter\TemplateFilterInterface;
use Fxp\Component\Mailer\Filter\TransportFilterInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for filter registry.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterRegistryTest extends TestCase
{
    public function test()
    {
        $templateFilter = $this->getMockBuilder(TemplateFilterInterface::class)->getMock();
        $transportFilter = $this->getMockBuilder(TransportFilterInterface::class)->getMock();

        $registry = new FilterRegistry([$templateFilter], [$transportFilter]);

        $templateFilters = $registry->getTemplateFilters();
        $transportFilters = $registry->getTransportFilters();

        $this->assertCount(1, $templateFilters);
        $this->assertCount(1, $transportFilters);

        $this->assertSame($templateFilter, $templateFilters[0]);
        $this->assertSame($transportFilter, $transportFilters[0]);
    }
}
