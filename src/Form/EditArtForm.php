<?php

namespace App\Form;

use App\Entity\Art;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditArtForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('categories', ChoiceType::class, [
                'choices' => [
                'Dessin' => 'Dessin',
                'Sculpture' => 'Sculpture',
                'Tatouage' => 'Tatouage',
                ],
            'label' => 'Catégorie',
            'placeholder' => 'Choisissez une catégorie',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Art::class,
        ]);
    }
}
