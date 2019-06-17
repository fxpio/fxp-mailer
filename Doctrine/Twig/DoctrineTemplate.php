<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Doctrine\Twig;

use Fxp\Component\Mailer\Model\TemplateMessageInterface;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DoctrineTemplate
{
    /**
     * @var int|string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var null|string
     */
    protected $type;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var null|\DateTime
     */
    protected $updatedAt;

    public function __construct(TemplateMessageInterface $template)
    {
        $id = $template->getId();
        $this->id = \is_int($id) ? $id : (string) $id;
        $this->name = (string) $template->getName();
        $this->type = $template->getType();
        $this->body = (string) $template->getBody();

        if (method_exists($template, 'getUpdatedAt') && ($date = $template->getUpdatedAt()) instanceof \DateTime) {
            $this->updatedAt = clone $date;
        }
    }

    /**
     * Gets the id.
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the unique template name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the type.
     *
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get the body.
     *
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Get the date of update of model.
     *
     * @return null|\DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
