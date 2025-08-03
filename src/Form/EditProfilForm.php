<?php

namespace App\Form;

use App\Entity\User;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditProfilForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'label' => 'Votre e-mail',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'nom@email.com...'
                ]])
            ->add('username', null, [
                'label' => 'Votre pseudonyme',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Username123...'
                ]
            ])

            ->add('password', PasswordType::class,[
                'label' => 'Confirmer avec votre mot de passe',
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '*******'
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
