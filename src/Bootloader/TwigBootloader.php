<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Bootloader;

use Spiral\Boot\AbstractKernel;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Symfony\Form\Config\FormConfig;
use Spiral\Symfony\Form\Twig\Extension\FormExtension;
use Spiral\Symfony\Form\Twig\TwigRendererEngine;
use Spiral\Twig\Bootloader\TwigBootloader as TwigBridgeBootloader;
use Spiral\Twig\TwigEngine;
use Spiral\Views\Bootloader\ViewsBootloader;
use Spiral\Views\ViewManager;
use Spiral\Views\ViewsInterface;
use Symfony\Component\Form\FormRenderer;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use Zentlix\TwigExtensions\Bootloader\ExtensionsBootloader;

final class TwigBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        TwigBridgeBootloader::class,
        ExtensionsBootloader::class,
    ];

    public function init(ViewsBootloader $views): void
    {
        $views->addDirectory(
            'forms',
            \dirname(__DIR__, 2).'/views/twig'
        );
    }

    public function boot(AbstractKernel $kernel, TwigBridgeBootloader $twig): void
    {
        $twig->addExtension(new FormExtension());

        $kernel->booted(function (ViewsInterface $views, FormConfig $config) {
            $this->registerTwigRuntimeLoader($views, $config);
        });
    }

    private function registerTwigRuntimeLoader(ViewsInterface $views, FormConfig $config): void
    {
        if (!$views instanceof ViewManager) {
            return;
        }

        foreach ($views->getEngines() as $engine) {
            if ($engine instanceof TwigEngine) {
                $twig = $engine->getEnvironment($views->getContext());
                $formEngine = new TwigRendererEngine([$config->getTheme()], $twig);
                $twig->addRuntimeLoader(new FactoryRuntimeLoader([
                    FormRenderer::class => static fn (): FormRenderer => new FormRenderer($formEngine),
                ]));
            }
        }
    }
}
