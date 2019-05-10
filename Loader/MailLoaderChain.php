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

use Fxp\Component\Mailer\Exception\UnknownMailException;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Model\MailInterface;

/**
 * Mail loader chain.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class MailLoaderChain implements MailLoaderInterface
{
    /**
     * @var MailLoaderInterface[]
     */
    protected $loaders;

    /**
     * Constructor.
     *
     * @param MailLoaderInterface[] $loaders The layout loaders
     */
    public function __construct(array $loaders)
    {
        $this->loaders = [];

        foreach ($loaders as $loader) {
            $this->addLoader($loader);
        }
    }

    /**
     * Add the layout template loader.
     *
     * @param MailLoaderInterface $loader The layout loader
     */
    public function addLoader(MailLoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function load(string $name, string $type = MailTypes::TYPE_ALL): MailInterface
    {
        foreach ($this->loaders as $loader) {
            try {
                return $loader->load($name, $type);
            } catch (UnknownMailException $e) {
                // do nothing, check the next loader
            }
        }

        throw new UnknownMailException($name, $type);
    }
}
