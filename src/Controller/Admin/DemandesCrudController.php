<?php

namespace App\Controller\Admin;

use App\Entity\Demandes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class DemandesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Demandes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('demandeurs', 'Demandeur'),
            TextEditorField::new('Message'),
            AssociationField::new('artiste', 'Artiste'),
            TextEditorField::new('reponse', 'Réponse'),
        ];
    }
}
