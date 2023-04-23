<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional;

use Spiral\Symfony\Form\Bootloader\FormBootloader;
use Spiral\Symfony\Form\Bootloader\TwigBootloader;

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
            FormBootloader::class,
            TwigBootloader::class,
        ];
    }
}
