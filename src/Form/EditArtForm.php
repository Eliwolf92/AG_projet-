<?php

namespace App\Form;

use App\Entity\Art;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditArtForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de l’œuvre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex : Le Cri'
                ],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Détaillez votre œuvre ici...',
                    'rows' => 5
                ],
            ])
            ->add('categories', ChoiceType::class, [
                'choices' => [
                    'Dessin' => 'Dessin',
                    'Sculpture' => 'Sculpture',
                    'Tatouage' => 'Tatouage',
                ],
                'label' => 'Catégorie',
                'placeholder' => 'Choisissez une catégorie',
                'attr' => [
                    'class' => 'form-select'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Art::class,
        ]);
    }
}
