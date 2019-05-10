<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Loader;

use Fxp\Component\Mailer\Loader\ConfigTemplateLayoutLoader;
use Fxp\Component\Mailer\Model\TemplateLayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for config template layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ConfigTemplateLayoutLoaderTest extends TestCase
{
    public function testLoad(): void
    {
        $template = [
            'name' => 'test',
            'label' => 'Test',
            'description' => 'Description of test',
            'enabled' => true,
            'body' => 'Content of layout with {{ twig_variable }}.',
            'translations' => [
                [
                    'locale' => 'fr',
                    'label' => 'Test fr',
                    'description' => 'Description du test',
                    'body' => 'Contenu du layout avec {{ twig_variable }}.',
                ],
            ],
        ];

        $loader = new ConfigTemplateLayoutLoader([$template]);

        $this->assertInstanceOf(TemplateLayoutInterface::class, $loader->load('test'));
    }

    public function testLoadUnknownTemplate(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\UnknownLayoutException::class);
        $this->expectExceptionMessage('The "test" layout template does not exist');

        $loader = new ConfigTemplateLayoutLoader([]);

        $loader->load('test');
    }
}
