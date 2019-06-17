<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Doctrine\Twig\Loader;

use Doctrine\Common\Persistence\ManagerRegistry;
use Fxp\Component\Mailer\Doctrine\Repository\TemplateMessageRepositoryInterface;
use Fxp\Component\Mailer\Doctrine\Twig\DoctrineTemplate;
use Fxp\Component\Mailer\Model\TemplateMessageInterface;
use Symfony\Component\Intl\Locales;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Loader\SourceContextLoaderInterface;
use Twig\Source;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class DoctrineTemplateLoader implements LoaderInterface, SourceContextLoaderInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var DoctrineTemplate[]
     */
    private $cache = [];

    /**
     * @var bool[]
     */
    private $errorCache = [];

    /**
     * Constructor.
     *
     * @param ManagerRegistry $doctrine
     * @param string          $namespace
     */
    public function __construct(
        ManagerRegistry $doctrine,
        string $namespace = 'doctrine_template_messages'
    ) {
        $this->doctrine = $doctrine;
        $this->namespace = $namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceContext($name): Source
    {
        $template = $this->getTemplate($name);
        $code = null !== $template ? $template->getBody() : '';

        return new Source($code, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name): string
    {
        $template = $this->getTemplate($name);

        return (null !== $template ? $template->getId() : '').'_'.$name;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time): bool
    {
        $template = $this->getTemplate($name);

        return null !== $template && null !== $template->getUpdatedAt()
            ? $template->getUpdatedAt()->getTimestamp() <= $time
            : false;
    }

    /**
     * {@inheritdoc}
     *
     * @throws
     */
    public function exists($name): bool
    {
        return null !== $this->getTemplate($name, false);
    }

    /**
     * Get the template.
     *
     * @param string $name  The template message name
     * @param bool   $throw Check if the exception must be thrown
     *
     * @throws LoaderError
     *
     * @return null|DoctrineTemplate
     */
    protected function getTemplate(string $name, bool $throw = true): ?DoctrineTemplate
    {
        if ($this->validateAndSkip($name, $throw)) {
            return null;
        }

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $criteria = $this->getCriteria($name);
        $repo = $this->getRepository();
        $templateMessage = null !== $repo ? $repo->findTemplate(...array_values($criteria)) : null;
        $template = null !== $templateMessage ? new DoctrineTemplate($templateMessage) : null;

        if (null !== $template) {
            $this->cache[$name] = $template;
        } else {
            $this->errorCache[$name] = true;
        }

        if ($throw && null === $template) {
            throw new LoaderError(sprintf('Unable to find template "%s".', $name));
        }

        return $template;
    }

    /**
     * Validate the template name.
     *
     * @param string $name  The template message name
     * @param bool   $throw Check if the exception must be thrown
     *
     * @throws LoaderError
     *
     * @return null|bool
     */
    protected function validateAndSkip(string $name, bool $throw = true): bool
    {
        $skip = false;

        if (0 !== strpos($name, '@'.$this->namespace)) {
            $skip = true;
        } elseif (isset($this->errorCache[$name])) {
            if ($throw) {
                throw new LoaderError(sprintf('Unable to find template "%s".', $name));
            }
            $skip = true;
        }

        return $skip;
    }

    /**
     * Get the doctrine criteria by the template name.
     *
     * @param string $name The template name
     *
     * @return array The type, locale and unique name
     */
    protected function getCriteria(string $name): array
    {
        $names = explode('/', $name);
        unset($names[0]);
        $names = array_values($names);

        $type = null;
        $locale = null;
        $key = '';

        while (\count($names) > 0) {
            if (Locales::exists($names[0])) {
                $locale = $locale ?? $names[0];
            } elseif (null === $type && \count($names) >= 2) {
                $type = $names[0];
            } else {
                $key = ltrim($key.'/'.$names[0], '/');
            }

            unset($names[0]);
            $names = array_values($names);
        }

        return [
            'name' => $key,
            'type' => '' === $type ? null : $type,
            'locale' => $locale,
        ];
    }

    /**
     * @return null|TemplateMessageRepositoryInterface
     */
    protected function getRepository(): ?TemplateMessageRepositoryInterface
    {
        $repo = $this->doctrine->getRepository(TemplateMessageInterface::class);

        return $repo instanceof TemplateMessageRepositoryInterface ? $repo : null;
    }
}
