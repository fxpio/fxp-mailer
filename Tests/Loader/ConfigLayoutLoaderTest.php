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

use Fxp\Component\Mailer\Loader\ConfigLayoutLoader;
use Fxp\Component\Mailer\Model\LayoutInterface;
use PHPUnit\Framework\TestCase;

/**
 * Tests for config layout loader.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class ConfigLayoutLoaderTest extends TestCase
{
    public function testLoad()
    {
        $template = array(
            'name' => 'test',
            'label' => 'Test',
            'description' => 'Description of test',
            'enabled' => true,
            'body' => 'Content of layout with {{ twig_variable }}.',
            'translations' => array(
                array(
                    'locale' => 'fr',
                    'label' => 'Test fr',
                    'description' => 'Description du test',
                    'body' => 'Contenu du layout avec {{ twig_variable }}.',
                ),
            ),
        );

        $loader = new ConfigLayoutLoader(array($template));

        $this->assertInstanceOf(LayoutInterface::class, $loader->load('test'));
    }

    /**
     * @expectedException \Fxp\Component\Mailer\Exception\UnknownLayoutException
     * @€@expectedExceptionMessage The "test" layout template does not exist
     */
    public function testLoadUnknownTemplate()
    {
        $loader = new ConfigLayoutLoader(array());

        $loader->load('test');
    }
}
