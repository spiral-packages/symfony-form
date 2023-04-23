<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Unit\Config;

use PHPUnit\Framework\TestCase;
use Spiral\Core\Container\Autowire;
use Spiral\Symfony\Form\Config\FormConfig;
use Spiral\Symfony\Form\Processor\ProcessorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\FormTypeInterface;

final class FormConfigTest extends TestCase
{
    public function testGetTheme(): void
    {
        $config = new FormConfig(['theme' => 'forms:bootstrap_5_layout.twig']);

        $this->assertSame('forms:bootstrap_5_layout.twig', $config->getTheme());
    }

    public function testGetFormTypes(): void
    {
        $form = new class () extends AbstractType {};

        $types = [
            $form,
            $form::class,
            new Autowire($form::class)
        ];

        $config = new FormConfig(['form_types' => $types]);

        $this->assertSame($types, $config->getFormTypes());
    }

    public function testGetExtensions(): void
    {
        $extension = new class () implements FormExtensionInterface {
            public function getType(string $name): FormTypeInterface
            {
            }

            public function hasType(string $name): bool
            {
            }

            public function getTypeExtensions(string $name): array
            {
            }

            public function hasTypeExtensions(string $name): bool
            {
            }

            public function getTypeGuesser(): ?FormTypeGuesserInterface
            {
            }
        };

        $extensions = [
            $extension,
            $extension::class,
            new Autowire($extension::class)
        ];

        $config = new FormConfig(['extensions' => $extensions]);

        $this->assertSame($extensions, $config->getExtensions());
    }

    public function testGetProcessors(): void
    {
        $processor = new class () implements ProcessorInterface {
            public function process(): void
            {
            }
        };

        $processors = [
            $processor,
            $processor::class,
            new Autowire($processor::class)
        ];

        $config = new FormConfig(['processors' => $processors]);

        $this->assertSame($processors, $config->getProcessors());
    }
}
