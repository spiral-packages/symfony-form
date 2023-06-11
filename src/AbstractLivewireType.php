<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form;

abstract class AbstractLivewireType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'form_data';
    }
}
