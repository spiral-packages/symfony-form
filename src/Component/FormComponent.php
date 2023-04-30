<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Component;

use Spiral\Livewire\Attribute\Model;
use Spiral\Livewire\Component\LivewireComponent;
use Spiral\Livewire\Response;
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

        if ($this->form->isValid()) {
            $this->submit();
        }
    }

    public function dehydrate(Response $response): void
    {
        if ($this->form->isSubmitted() && !$this->form->isValid()) {
            $this->setValidationErrors($this->getFormErrors($this->form));
        }
    }

    // TODO add errors from child forms
    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors['formData.' . $form->getName() . '.' . $error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $errors;
    }

    abstract public function createForm(): FormInterface;

    abstract public function submit(): void;
}
