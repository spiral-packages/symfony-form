<?php

declare(strict_types=1);

namespace Spiral\Symfony\Form\Tests\App\Component\FormComponentTest\Form;

use Spiral\Symfony\Form\Attribute\FormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

#[FormType]
final class SignInForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email address'])
            ->add('password', PasswordType::class, ['label' => 'Password'])
            ->add('remember_me', CheckboxType::class, ['label' => 'Remember me', 'required' => false])
            ->add('save', SubmitType::class, ['label' => 'Sign in'])
        ;
    }
}
