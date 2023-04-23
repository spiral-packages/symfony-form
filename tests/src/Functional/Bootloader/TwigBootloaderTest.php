<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional\Bootloader;

use Spiral\Boot\DirectoriesInterface;
use Spiral\Symfony\Form\Tests\Functional\TestCase;
use Spiral\Symfony\Form\Twig\Extension\FormExtension;
use Spiral\Symfony\Form\Twig\Extension\TranslationExtension;
use Spiral\Twig\Config\TwigConfig;
use Spiral\Views\Config\ViewsConfig;

final class TwigBootloaderTest extends TestCase
{
    public function testViewsDirectoryShouldBeRegistered(): void
    {
        $dirs = $this->getContainer()->get(DirectoriesInterface::class);

        $config = $this->getConfig(ViewsConfig::CONFIG);

        $this->assertIsArray($config['namespaces']['forms']);
        $this->assertSame(
            \rtrim($dirs->get('vendor'), '/').'/spiral-packages/symfony-form/views/twig',
            $config['namespaces']['forms'][0]
        );
    }

    public function testExtensionsShouldBeRegistered(): void
    {
        $config = $this->getConfig(TwigConfig::CONFIG);

        $this->assertContainsEquals(new FormExtension(), $config['extensions']);
        $this->assertContainsEquals($this->getContainer()->get(TranslationExtension::class), $config['extensions']);
    }
}
