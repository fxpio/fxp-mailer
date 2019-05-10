<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Filter;

/**
 * The filter registry of template and transport.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterRegistry implements FilterRegistryInterface
{
    /**
     * @var TemplateFilterInterface[]
     */
    protected $templateFilters;

    /**
     * @var TransportFilterInterface[]
     */
    protected $transportFilters;

    /**
     * Constructor.
     *
     * @param TemplateFilterInterface[]  $templateFilters  The template filters
     * @param TransportFilterInterface[] $transportFilters The transport filters
     */
    public function __construct(array $templateFilters = [], array $transportFilters = [])
    {
        $this->templateFilters = [];
        $this->transportFilters = [];

        foreach ($templateFilters as $filter) {
            $this->addTemplateFilter($filter);
        }

        foreach ($transportFilters as $filter) {
            $this->addTransportFilter($filter);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addTemplateFilter(TemplateFilterInterface $filter): self
    {
        $this->templateFilters[] = $filter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateFilters(): array
    {
        return $this->templateFilters;
    }

    /**
     * {@inheritdoc}
     */
    public function addTransportFilter(TransportFilterInterface $filter): self
    {
        $this->transportFilters[] = $filter;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransportFilters(): array
    {
        return $this->transportFilters;
    }
}
