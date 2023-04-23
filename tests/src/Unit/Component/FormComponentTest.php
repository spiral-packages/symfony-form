<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Unit\Component;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Core\ResolverInterface;
use Spiral\Livewire\Component\PropertyHasherInterface;
use Spiral\Router\RouterInterface;
use Spiral\Symfony\Form\Tests\App\Component\FormComponentTest\Component\SignInComponent;
use Spiral\Symfony\Form\Tests\App\Component\FormComponentTest\Form\SignInForm;
use Spiral\Views\ViewsInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class FormComponentTest extends TestCase
{
    public function testBootShouldCallCreateForm(): void
    {
        $form = $this->createMock(FormInterface::class);
        $factory = $this->createMock(FormFactoryInterface::class);
        $factory
            ->expects($this->once())
            ->method('create')
            ->with(SignInForm::class)
            ->willReturn($form);

        $component = new SignInComponent($factory);
        $component->boot();

        $this->assertSame($form, $component->getForm());
    }

    public function testRenderToViewShouldCreateFormView(): void
    {
        $formView = $this->createMock(FormView::class);
        $form = $this->createMock(FormInterface::class);
        $form
            ->expects($this->once())
            ->method('createView')
            ->willReturn($formView);

        $factory = $this->createMock(FormFactoryInterface::class);
        $factory
            ->expects($this->once())
            ->method('create')
            ->with(SignInForm::class)
            ->willReturn($form);

        $component = new SignInComponent($factory);
        $ref = new \ReflectionMethod($component, 'configure');
        $ref->invoke($component,
            'foo',
            'bar',
            $this->createMock(ViewsInterface::class),
            $this->createMock(ResolverInterface::class),
            $this->createMock(PropertyHasherInterface::class),
            $this->createMock(EventDispatcherInterface::class),
            $this->createMock(RouterInterface::class)
        );

        $component->boot();
        $component->renderToView();

        $this->assertSame($formView, $component->getRenderContext()['form']);
    }

    public function testHandleShouldCallHandleRequestAndSubmit(): void
    {
        $form = $this->createMock(FormInterface::class);
        $form
            ->expects($this->once())
            ->method('handleRequest')
            ->with(['email' => 'foo@gmail.com']);
        $form
            ->expects($this->once())
            ->method('getData')
            ->willReturn(['email' => 'foo@gmail.com']);

        $factory = $this->createMock(FormFactoryInterface::class);
        $factory
            ->expects($this->once())
            ->method('create')
            ->with(SignInForm::class)
            ->willReturn($form);

        $component = new SignInComponent($factory);
        $component->formData = ['email' => 'foo@gmail.com'];
        $component->boot();
        $component->handle();

        $this->assertSame(['email' => 'foo@gmail.com'], $component->getData());
    }
}
