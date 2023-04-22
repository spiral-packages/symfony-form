<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Component;

use Spiral\Livewire\Attribute\Model;
use Spiral\Livewire\Component\LivewireComponent;
use Spiral\Views\ViewInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

abstract class FormComponent extends LivewireComponent
{
    protected FormInterface $form;

    #[Model]
    public array $formData = [];

    public function __construct(
        protected readonly FormFactoryInterface $formFactory
    ) {
    }

    public function boot(): void
    {
        $this->form = $this->createForm();
    }

    public function renderToView(): ViewInterface
    {
        $this->renderContext['form'] = $this->form->createView();

        return parent::renderToView();
    }

    public function handle(): void
    {
        $this->form->handleRequest($this->formData);
    }

    abstract public function createForm(): FormInterface;

    abstract public function submit(): void;
}
