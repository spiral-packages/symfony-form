<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional\Bootloader;

use Spiral\Symfony\Form\Tests\Functional\TestCase;
use Spiral\Symfony\Form\Twig\Extension\FormExtension;
use Spiral\Twig\Config\TwigConfig;
use Spiral\Views\Config\ViewsConfig;

final class TwigBootloaderTest extends TestCase
{
    public function testViewsDirectoryShouldBeRegistered(): void
    {
        $config = $this->getConfig(ViewsConfig::CONFIG);

        $this->assertIsArray($config['namespaces']['forms']);
        $this->assertSame(
            \dirname(__DIR__, 4).'/views/twig',
            $config['namespaces']['forms'][0]
        );
    }

    public function testFormExtensionShouldBeRegistered(): void
    {
        $config = $this->getConfig(TwigConfig::CONFIG);

        $this->assertContainsEquals(new FormExtension(), $config['extensions']);
    }
}
