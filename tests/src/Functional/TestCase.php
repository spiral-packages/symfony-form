<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional;

use Spiral\Bootloader\Http\RouterBootloader;
use Spiral\Nyholm\Bootloader\NyholmBootloader;
use Spiral\Symfony\Form\Bootloader\FormBootloader;
use Spiral\Symfony\Form\Bootloader\TwigBootloader;
use Spiral\Validation\Symfony\Bootloader\ValidatorBootloader;

abstract class TestCase extends \Spiral\Testing\TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->cleanUpRuntimeDirectory();
    }

    public function rootDirectory(): string
    {
        return \dirname(__DIR__, 2);
    }

    public function defineDirectories(string $root): array
    {
        return \array_merge(
            ['views' => $root . '/views'],
            parent::defineDirectories($root)
        );
    }

    public function defineBootloaders(): array
    {
        return [
            NyholmBootloader::class,
            RouterBootloader::class,
            ValidatorBootloader::class,
            FormBootloader::class,
            TwigBootloader::class,
        ];
    }
}
