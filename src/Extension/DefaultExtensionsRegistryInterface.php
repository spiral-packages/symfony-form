<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Extension;

use Spiral\Core\Container\Autowire;
use Spiral\Symfony\Form\Config\FormConfig;
use Symfony\Component\Form\FormExtensionInterface;

/**
 * @psalm-import-type TExtension from FormConfig
 */
interface DefaultExtensionsRegistryInterface
{
    /**
     * @psalm-param TExtension $extension
     */
    public function add(FormExtensionInterface|Autowire|string $extension): void;

    /**
     * @return FormExtensionInterface[]
     */
    public function getExtensions(): array;
}
