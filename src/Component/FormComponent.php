<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Component;

use Spiral\Livewire\Attribute\Model;
use Spiral\Livewire\Component\LivewireComponent;
use Spiral\Livewire\Response;
use Spiral\Views\ViewInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class FormComponent extends LivewireComponent
{
    protected ?FormInterface $form = null;

    #[Model]
    public array $form_data = [];

    public function renderToView(): ViewInterface
    {
        if ($this->form === null) {
            $this->form = $this->createForm();
        }

        $this->renderContext['form'] = $this->form->createView();
        $this->setData($this->renderContext['form']);

        return parent::renderToView();
    }

    public function handle(): void
    {
        if ($this->form === null) {
            $this->form = $this->createForm();
        }

        $this->form->handleRequest(['form_data' => $this->form_data]);

        if ($this->form->isValid()) {
            $this->submit();
        }
    }

    public function dehydrate(Response $response): void
    {
        if ($this->form !== null && $this->form->isSubmitted() && !$this->form->isValid()) {
            $this->setValidationErrors($this->getFormErrors($this->form));
        }
    }

    // TODO add errors from child forms
    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        /** @var FormError $error */
        foreach ($form->getErrors(true) as $error) {
            $errors['form_data.' . $form->getName() . '.' . $error->getOrigin()?->getName()][] = $error->getMessage();
        }

        return $errors;
    }

    private function setData(FormView $formView): void
    {
        $propertyAccess = new PropertyAccessor();
        $childrenData = function (FormView $form) use (&$childrenData, $propertyAccess): void {
            if ($form->children === []) {
                $propertyAccess->setValue($this, $form->vars['full_name'], $form->vars['value']);
            }

            foreach ($form->children as $child) {
                $childrenData($child);
            }
        };

        foreach ($formView->children as $child) {
            $childrenData($child);
        }
    }

    abstract public function createForm(): FormInterface;

    abstract public function submit(): void;
}
