<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('username')
                ->setRequired(true),
            TextField::new('email'),
            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setRequired(false)
                ->setHelp('Veuillez entrer un mot de passe fort'),
            ChoiceField::new('roles')
                ->setChoices([
                    'Artiste' => 'ROLE_ARTISTE',
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ])
                ->allowMultipleChoices()
                ->setRequired(true)
                ->setHelp('Sélectionnez le rôle de l\'utilisateur'),
        ];
    }

}
