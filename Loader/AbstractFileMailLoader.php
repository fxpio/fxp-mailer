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

use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\MailInterface;
use Fxp\Component\Mailer\Util\ConfigUtil;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Base of file mail loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
abstract class AbstractFileMailLoader extends ConfigMailLoader
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var null|string[]
     */
    protected $resources;

    /**
     * Constructor.
     *
     * @param string|string[]       $resources    The resources
     * @param LayoutLoaderInterface $layoutLoader The layout loader
     * @param KernelInterface       $kernel       The kernel
     */
    public function __construct($resources, LayoutLoaderInterface $layoutLoader, KernelInterface $kernel)
    {
        parent::__construct([], $layoutLoader);

        $this->kernel = $kernel;
        $this->resources = (array) $resources;
    }

    /**
     * {@inheritdoc}
     */
    public function load(string $name, string $type = MailTypes::TYPE_ALL): MailInterface
    {
        if (\is_array($this->resources)) {
            foreach ($this->resources as $resource) {
                $config = ConfigUtil::formatTranslationConfig($resource, $this->kernel);
                $this->addMail($this->createMail($config));
            }

            $this->resources = null;
        }

        return parent::load($name, $type);
    }
}
