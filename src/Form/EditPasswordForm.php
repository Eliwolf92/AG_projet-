<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditPasswordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldpassword',  PasswordType::class, [
                'label' => 'Votre ancien mot de passe',
                'mapped' => false,
                'attr' =>[
                    'class' => 'form-control',
                    'placeholder' => "votre ancien mot de passe..."
                ]
            ])

            ->add('newpassword',  PasswordType::class,[
                'label' => 'Votre Nouveau mot de passe',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'votre nouveau mot de passe...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
