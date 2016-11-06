<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Component\Mailer\Tests\Model;

use Sonatra\Component\Mailer\Model\TwigLayout;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for twig layout template model.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class TwigLayoutTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $file;

    protected function setUp()
    {
        $this->file = sys_get_temp_dir().'/sonatra_mailer_tests/file.html.twig';
        $fs = new Filesystem();
        $fs->dumpFile($this->file, 'content');
    }

    protected function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove(dirname($this->file));
    }

    public function testModel()
    {
        $layout = new TwigLayout($this->file);

        $this->assertSame($this->file, $layout->getFile());
    }

    /**
     * @expectedException \Sonatra\Component\Mailer\Exception\InvalidArgumentException
     * @expectedExceptionMessage The "file.ext" file is not supported by the layout file template
     */
    public function testInvalidFile()
    {
        new TwigLayout('file.ext');
    }
}
