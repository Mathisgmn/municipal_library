<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [new Assert\NotBlank(), new Assert\Email()]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 100])]
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 100])]
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 12, 'max' => 4096]),
                    new Assert\Regex([
                        'pattern' => '/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9])/',
                        'message' => 'Le mot de passe doit contenir majuscule, minuscule, chiffre et symbole'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
