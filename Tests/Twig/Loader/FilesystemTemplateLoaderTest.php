<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Twig\Loader;

use Fxp\Component\Mailer\Twig\Loader\FilesystemTemplateLoader;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class FilesystemTemplateLoaderTest extends TestCase
{
    /**
     * @var FilesystemTemplateLoader
     */
    protected $loader;

    /**
     * @var string
     */
    protected $rootPath;

    /**
     * @throws
     */
    protected function setUp(): void
    {
        $this->rootPath = realpath(__DIR__.'/../../Fixtures');
        \Locale::setDefault('fr_FR');

        $this->loader = new FilesystemTemplateLoader(
            $this->rootPath,
            'en_US',
            'loaders',
            'template_messages'
        );
    }

    protected function tearDown(): void
    {
        $this->loader = null;
    }

    public function getExistsArguments(): array
    {
        return [
            [false, 'mail.html.twig'],
            [false, 'mail.fr.html.twig'],
            [true,  '@template_messages/mail.html.twig'],
            [true,  '@template_messages/mail.fr_FR.html.twig'],
            [true,  '@template_messages/mail.fr.html.twig'],
            [true,  '@template_messages/mail.en_US.html.twig'],
            [true,  '@template_messages/mail.en.html.twig'],
            [true,  '@template_messages/mail.it_IT.html.twig'],
            [true,  '@template_messages/mail.it.html.twig'],
            [false, '@template_messages/mail.aa_AA.html.twig'],
            [false, '@template_messages/mail.aa.html.twig'],
        ];
    }

    /**
     * @dataProvider getExistsArguments
     *
     * @param bool   $expected
     * @param string $templateName
     */
    public function testExists(bool $expected, string $templateName): void
    {
        static::assertSame($expected, $this->loader->exists($templateName));
    }

    public function getGetSourceContextArguments(): array
    {
        return [
            ['@template_messages/mail.html.twig', 'loaders/mail.fr.html.twig'],
            ['@template_messages/mail.fr_FR.html.twig', 'loaders/mail.fr.html.twig'],
            ['@template_messages/mail.fr.html.twig', 'loaders/mail.fr.html.twig'],
            ['@template_messages/mail.en_US.html.twig', 'loaders/mail.en.html.twig'],
            ['@template_messages/mail.en.html.twig', 'loaders/mail.en.html.twig'],
            ['@template_messages/mail.it_IT.html.twig', 'loaders/mail.en.html.twig'],
            ['@template_messages/mail.it.html.twig', 'loaders/mail.en.html.twig'],
        ];
    }

    /**
     * @dataProvider getGetSourceContextArguments
     *
     * @param string $templateName
     * @param string $expectedPath
     *
     * @throws
     */
    public function testGetSourceContext(string $templateName, string $expectedPath): void
    {
        $source = $this->loader->getSourceContext($templateName);
        $path = str_replace('\\', '/', substr($source->getPath(), \strlen($this->rootPath) + 1));

        static::assertSame($expectedPath, $path);
    }

    /**
     * @throws
     */
    public function testGetSourceContextWithInvalidName(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Unable to find template "@template_messages/invalid.en_US.html.twig');

        $this->loader->getSourceContext('@template_messages/invalid.en_US.html.twig');
    }
}
