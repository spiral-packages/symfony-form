<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional;

use Spiral\Symfony\Form\Bootloader\FormBootloader;

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

    public function defineBootloaders(): array
    {
        return [
            FormBootloader::class
        ];
    }
}
