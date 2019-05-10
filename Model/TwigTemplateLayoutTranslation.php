<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Model;

use Fxp\Component\Mailer\Exception\InvalidArgumentException;
use Fxp\Component\Mailer\Model\Traits\TemplateFileTrait;

/**
 * Model for twig file layout translation.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class TwigTemplateLayoutTranslation extends TemplateLayoutTranslation implements TwigTemplateInterface
{
    use TemplateFileTrait;

    /**
     * Constructor.
     *
     * @param TemplateLayoutInterface $layout The layout
     * @param null|string             $file   The file name
     */
    public function __construct(TemplateLayoutInterface $layout, ?string $file = null)
    {
        parent::__construct($layout);

        $this->setFile($file);
        $this->body = 'body';
    }

    /**
     * {@inheritdoc}
     */
    protected function support(?string $file): void
    {
        if (null !== $file && 'twig' !== pathinfo($file, PATHINFO_EXTENSION)) {
            $msg = 'The "%s" file is not supported by the layout translation file template';

            throw new InvalidArgumentException(sprintf($msg, $file));
        }
    }
}
