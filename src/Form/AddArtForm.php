<?php

namespace App\Form;

use App\Entity\Art;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddArtForm extends AbstractType
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
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de l\'œuvre',
                'required' => true,
                'allow_delete' => false,
                'download_uri' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Art::class,
        ]);
    }
}
