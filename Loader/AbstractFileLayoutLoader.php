<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Loader;

use Fxp\Component\Mailer\Util\ConfigUtil;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Base of file layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractFileLayoutLoader extends ConfigLayoutLoader
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var string[]|null
     */
    protected $resources;

    /**
     * Constructor.
     *
     * @param string|string[]|array[] $resources The resources
     * @param KernelInterface         $kernel    The kernel
     */
    public function __construct($resources, KernelInterface $kernel)
    {
        parent::__construct(array());

        $this->kernel = $kernel;
        $this->resources = (array) $resources;
    }

    /**
     * {@inheritdoc}
     */
    public function load($name)
    {
        if (is_array($this->resources)) {
            foreach ($this->resources as $resource) {
                $config = ConfigUtil::formatTranslationConfig($resource, $this->kernel);
                $this->addLayout($this->createLayout($config));
            }

            $this->resources = null;
        }

        return parent::load($name);
    }
}
