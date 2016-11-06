<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Tests\Filter;

use Sonatra\Component\Mailer\Filter\FilterRegistry;
use Sonatra\Component\Mailer\Filter\TemplateFilterInterface;
use Sonatra\Component\Mailer\Filter\TransportFilterInterface;

/**
 * Tests for filter registry.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class FilterRegistryTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $templateFilter = $this->getMockBuilder(TemplateFilterInterface::class)->getMock();
        $transportFilter = $this->getMockBuilder(TransportFilterInterface::class)->getMock();

        $registry = new FilterRegistry(array($templateFilter), array($transportFilter));

        $templateFilters = $registry->getTemplateFilters();
        $transportFilters = $registry->getTransportFilters();

        $this->assertCount(1, $templateFilters);
        $this->assertCount(1, $transportFilters);

        $this->assertSame($templateFilter, $templateFilters[0]);
        $this->assertSame($transportFilter, $transportFilters[0]);
    }
}
