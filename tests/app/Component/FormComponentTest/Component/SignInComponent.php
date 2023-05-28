<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\App\Component\FormComponentTest\Component;

use Spiral\Symfony\Form\Component\FormComponent;
use Spiral\Symfony\Form\Tests\App\Component\FormComponentTest\Form\SignInForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

final class SignInComponent extends FormComponent
{
    private array $data = [];

    public function __construct(
        private readonly FormFactoryInterface $formFactory
    ) {
    }

    public function createForm(): FormInterface
    {
        return $this->formFactory->create(SignInForm::class);
    }

    public function submit(): void
    {
        $this->data = $this->form->getData();
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function getRenderContext(): array
    {
        return $this->renderContext;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
