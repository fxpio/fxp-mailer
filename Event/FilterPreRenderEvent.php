<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class event for the template.pre_render event.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class FilterPreRenderEvent extends Event
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $variables;

    /**
     * @var string
     */
    protected $type;

    /**
     * Constructor.
     *
     * @param string $template  The mail template name
     * @param array  $variables The variables of template
     * @param string $type      The mail type defined in MailTypes::TYPE_*
     */
    public function __construct(string $template, array $variables, string $type)
    {
        $this->template = $template;
        $this->variables = $variables;
        $this->type = $type;
    }

    /**
     * Set the template.
     *
     * @param string $template The template
     *
     * @return static
     */
    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get the template.
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Set the variables.
     *
     * @param array $variables The variables
     *
     * @return static
     */
    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * Get the variables.
     *
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Set the mail type.
     *
     * @param string $type The mail type defined in MailTypes::TYPE_*
     *
     * @return static
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the mail type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
