<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Tests\Model;

use Fxp\Component\Mailer\Model\TemplateMailInterface;
use Fxp\Component\Mailer\Model\TwigTemplateMailTranslation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Tests for twig mail translation template model.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class TwigTemplateMailTranslationTest extends TestCase
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var TemplateMailInterface
     */
    protected $mail;

    protected function setUp(): void
    {
        $this->file = sys_get_temp_dir().'/fxp_mailer_tests/file.html.twig';
        $this->mail = $this->getMockBuilder(TemplateMailInterface::class)->getMock();
        $fs = new Filesystem();
        $fs->dumpFile($this->file, 'content');
    }

    protected function tearDown(): void
    {
        $fs = new Filesystem();
        $fs->remove(\dirname($this->file));
    }

    public function testModel(): void
    {
        $mail = new TwigTemplateMailTranslation($this->mail, $this->file);

        $this->assertSame($this->file, $mail->getFile());
    }

    public function testInvalidFile(): void
    {
        $this->expectException(\Fxp\Component\Mailer\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('The "file.ext" file is not supported by the mail translation file template');

        new TwigTemplateMailTranslation($this->mail, 'file.ext');
    }
}
