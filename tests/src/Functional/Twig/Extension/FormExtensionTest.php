<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\Functional\Twig\Extension;

use Spiral\Symfony\Form\Tests\App\Component\FormComponentTest\Form\SignInForm;
use Spiral\Symfony\Form\Tests\Functional\TestCase;
use Spiral\Views\ViewsInterface;
use Symfony\Component\Form\FormFactoryInterface;

final class FormExtensionTest extends TestCase
{
    public function testRenderForm(): void
    {
        /** @var FormFactoryInterface $form */
        $form = $this->getContainer()->get(FormFactoryInterface::class);
        /** @var ViewsInterface $views */
        $views = $this->getContainer()->get(ViewsInterface::class);

        $html = $views->render('sign-in.twig', ['form' => $form->create(SignInForm::class)->createView()]);

        $this->assertStringContainsString('<form name="sign_in_form" method="post">', $html);
        $this->assertStringContainsString('<label for="sign_in_form_email" class="form-label required">Email address</label>', $html);
        $this->assertStringContainsString('<input type="email" id="sign_in_form_email" name="sign_in_form[email]" required="required" class="form-control" />', $html);
        $this->assertStringContainsString('<label for="sign_in_form_password" class="form-label required">Password</label>', $html);
        $this->assertStringContainsString('<input type="password" id="sign_in_form_password" name="sign_in_form[password]" required="required" class="form-control" />', $html);
        $this->assertStringContainsString('<input type="checkbox" id="sign_in_form_remember_me" name="sign_in_form[remember_me]" class="form-check-input" value="1" />', $html);
        $this->assertStringContainsString('<label class="form-check-label" for="sign_in_form_remember_me">Remember me</label>', $html);
        $this->assertStringContainsString('<button type="submit" id="sign_in_form_save" name="sign_in_form[save]" class="btn-primary btn">Sign in</button>', $html);
    }
}
