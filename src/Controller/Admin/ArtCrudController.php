<?php

namespace App\Controller\Admin;

use App\Entity\Art;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArtCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Art::class;
    }

    public function __construct(private UserRepository $userRepository) {}
    
    public function configureFields(string $pageName): iterable
    {
         $artists = $this->userRepository->findAll();
        $artistChoices = [];

        $categories = [     'Dessin' => 'Dessin',
                            'Sculpture' => 'Sculpture',
                            'Tatouage' => 'Tatouage',];

    foreach ($artists as $artiste) {
        if (in_array('ROLE_ARTISTE', $artiste->getRoles())) {
            $artistChoices[$artiste->getUsername()] = $artiste->getId();
        }
    }
        return [
    TextField::new('name'),
    
    // Champ d'upload
    Field::new('imageFile')
        ->setFormType(VichImageType::class)
        ->setLabel('Image')
        ->onlyOnForms(),

    // Champ image affichée (dans liste ou show)
    ImageField::new('img')
        ->setBasePath('/uploads/art')
        ->setLabel('Aperçu')
        ->onlyOnIndex(),

    TextEditorField::new('description'),

    ChoiceField::new('categories')
        ->setChoices([
            'Dessin' => 'Dessin',
            'Sculpture' => 'Sculpture',
            'Tatouage' => 'Tatouage',
        ]),

    AssociationField::new('artiste')
        ->setLabel('Artiste')
        ->setQueryBuilder(function (\Doctrine\ORM\QueryBuilder $qb) {
            return $qb
                ->where('entity.roles LIKE :role')
                ->setParameter('role', '%ROLE_ARTISTE%');
        }),


        ];
    }
    
}
