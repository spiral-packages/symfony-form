<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Extension\HttpFoundation;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Form\Extension\HttpFoundation\Type\FormTypeHttpFoundationExtension;

final class HttpFoundationExtension extends AbstractExtension
{
    public function __construct(
        private readonly FormTypeHttpFoundationExtension $formTypeHttpFoundationExtension
    ) {
    }

    protected function loadTypeExtensions(): array
    {
        return [
            $this->formTypeHttpFoundationExtension,
        ];
    }
}
