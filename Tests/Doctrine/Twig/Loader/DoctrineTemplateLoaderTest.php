<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Doctrine\Twig\Loader;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectRepository;
use Fxp\Component\Mailer\Doctrine\Repository\TemplateMessageRepositoryInterface;
use Fxp\Component\Mailer\Doctrine\Twig\Loader\DoctrineTemplateLoader;
use Fxp\Component\Mailer\Model\TemplateMessageInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class DoctrineTemplateLoaderTest extends TestCase
{
    /**
     * @var ManagerRegistry|MockObject
     */
    protected $doctrine;

    /**
     * @var MockObject|ObjectRepository
     */
    protected $repo;

    /**
     * @var DoctrineTemplateLoader
     */
    protected $loader;

    /**
     * @throws
     */
    protected function setUp(): void
    {
        \Locale::setDefault('fr_FR');

        $this->repo = $this->getMockBuilder(TemplateMessageRepositoryInterface::class)->getMock();

        $this->doctrine = $this->getMockBuilder(ManagerRegistry::class)->getMock();

        $this->loader = new DoctrineTemplateLoader(
            $this->doctrine,
            'user_templates'
        );
    }

    protected function tearDown(): void
    {
        $this->doctrine = null;
        $this->loader = null;
    }

    public function getExistsArguments(): array
    {
        return [
            [false, 'mail',       null,    null,    'mail.html.twig'],
            [false, 'mail',       null,    null,    'mail.fr.html.twig'],
            [true,  'mail',       null,    null,    '@user_templates/mail'],
            [true,  'mail',       null,    'fr_FR', '@user_templates/fr_FR/mail'],
            [true,  'mail',       null,    'fr',    '@user_templates/fr/mail'],
            [true,  'mail',       null,    'en_US', '@user_templates/en_US/mail'],
            [true,  'mail',       null,    'en',    '@user_templates/en/mail'],
            [true,  'mail',       null,    'it_IT', '@user_templates/it_IT/mail'],
            [true,  'mail',       null,    'it',    '@user_templates/it/mail'],

            [true,  'mail',       'email', null,    '@user_templates/email/mail'],
            [true,  'mail',       'email', 'fr_FR', '@user_templates/email/fr_FR/mail'],
            [true,  'mail',       'email', 'fr',    '@user_templates/email/fr/mail'],
            [true,  'mail',       'email', 'en_US', '@user_templates/email/en_US/mail'],
            [true,  'mail',       'email', 'en',    '@user_templates/email/en/mail'],
            [true,  'mail',       'email', 'it_IT', '@user_templates/email/it_IT/mail'],
            [true,  'mail',       'email', 'it',    '@user_templates/email/it/mail'],

            [true,  'mail',       'email', 'fr_FR', '@user_templates/fr_FR/email/mail'],
            [true,  'mail',       'email', 'fr',    '@user_templates/fr/email/mail'],
            [true,  'mail',       'email', 'en_US', '@user_templates/en_US/email/mail'],
            [true,  'mail',       'email', 'en',    '@user_templates/en/email/mail'],
            [true,  'mail',       'email', 'it_IT', '@user_templates/it_IT/email/mail'],
            [true,  'mail',       'email', 'it',    '@user_templates/it/email/mail'],

            [false, 'mail',       'aa_AA', null,    '@user_templates/aa_AA/mail'],
            [false, 'mail',       'aa',    null,    '@user_templates/aa/mail'],

            [false, 'aa_AA/mail', 'email', null,    '@user_templates/email/aa_AA/mail'],
            [false, 'aa/mail',    'email', null,    '@user_templates/email/aa/mail'],
        ];
    }

    /**
     * @dataProvider getExistsArguments
     *
     * @param bool        $expected
     * @param null|string $expectedName
     * @param null|string $expectedType
     * @param null|string $expectedLocale
     * @param string      $templateName
     */
    public function testExists(
        bool $expected,
        string $expectedName,
        ?string $expectedType,
        ?string $expectedLocale,
        string $templateName
    ): void {
        if (0 === strpos($templateName, '@user_templates')) {
            $templateMessage = $expected ? $this->getTemplateMessage() : null;

            $this->doctrine->expects(static::once())
                ->method('getRepository')
                ->with(TemplateMessageInterface::class)
                ->willReturn($this->repo)
            ;

            $this->repo->expects(static::once())
                ->method('findTemplate')
                ->with($expectedName, $expectedType, $expectedLocale)
                ->willReturn($templateMessage)
            ;
        }

        static::assertSame($expected, $this->loader->exists($templateName));
        // cache test
        static::assertSame($expected, $this->loader->exists($templateName));
    }

    /**
     * @throws
     */
    public function testGetSourceContext(): void
    {
        $templateMessage = $this->getTemplateMessage();

        $this->doctrine->expects(static::once())
            ->method('getRepository')
            ->with(TemplateMessageInterface::class)
            ->willReturn($this->repo)
        ;

        $this->repo->expects(static::once())
            ->method('findTemplate')
            ->with('mail', 'email', 'fr_FR')
            ->willReturn($templateMessage)
        ;

        $source = $this->loader->getSourceContext('@user_templates/email/fr_FR/mail');

        static::assertNotNull($source);
        static::assertSame('@user_templates/email/fr_FR/mail', $source->getName());
        static::assertSame('template body', $source->getCode());
    }

    /**
     * @throws
     */
    public function testGetSourceContextWithNotFoundException(): void
    {
        $expectedExceptionClass = LoaderError::class;
        $expectedExceptionMessage = 'Unable to find template "@user_templates/email/fr_FR/mail".';

        $name = '@user_templates/email/fr_FR/mail';
        $exception = null;

        try {
            $this->loader->getSourceContext($name);
        } catch (\Exception $e) {
            $exception = $e;
        }

        static::assertInstanceOf($expectedExceptionClass, $exception);
        static::assertSame($expectedExceptionMessage, $exception->getMessage());

        // cache test
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->loader->getSourceContext($name);
    }

    /**
     * @throws
     */
    public function testGetCacheKey(): void
    {
        $templateMessage = $this->getTemplateMessage();

        $this->doctrine->expects(static::once())
            ->method('getRepository')
            ->with(TemplateMessageInterface::class)
            ->willReturn($this->repo)
        ;

        $this->repo->expects(static::once())
            ->method('findTemplate')
            ->with('mail', 'email', 'fr_FR')
            ->willReturn($templateMessage)
        ;

        $cacheKey = $this->loader->getCacheKey('@user_templates/email/fr_FR/mail');

        static::assertSame('42_@user_templates/email/fr_FR/mail', $cacheKey);
    }

    /**
     * @throws
     */
    public function testIsFresh(): void
    {
        $templateMessage = $this->getTemplateMessage();

        $this->doctrine->expects(static::once())
            ->method('getRepository')
            ->with(TemplateMessageInterface::class)
            ->willReturn($this->repo)
        ;

        $this->repo->expects(static::once())
            ->method('findTemplate')
            ->with('mail', 'email', 'fr_FR')
            ->willReturn($templateMessage)
        ;

        $expectedTime = $templateMessage->getUpdatedAt()->getTimestamp() - 1;
        $fresh = $this->loader->isFresh('@user_templates/email/fr_FR/mail', $expectedTime);

        static::assertFalse($fresh);
    }

    /**
     * @throws
     *
     * @return MockObject|TemplateMessageInterface
     */
    private function getTemplateMessage()
    {
        $datetime = new \DateTime();

        /** @var MockObject|TemplateMessageInterface $templateMessage */
        $templateMessage = $this->getMockBuilder(TemplateMessageInterface::class)->getMock();

        $templateMessage->expects(static::once())
            ->method('getId')
            ->willReturn(42)
        ;
        $templateMessage->expects(static::once())
            ->method('getName')
            ->willReturn('template_name')
        ;
        $templateMessage->expects(static::once())
            ->method('getType')
            ->willReturn('template_type')
        ;
        $templateMessage->expects(static::once())
            ->method('getBody')
            ->willReturn('template body')
        ;
        $templateMessage->expects(static::atLeastOnce())
            ->method('getUpdatedAt')
            ->willReturn($datetime)
        ;

        return $templateMessage;
    }
}
