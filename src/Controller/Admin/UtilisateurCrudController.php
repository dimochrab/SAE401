<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('index','EcoConnect - Administration des utilisateurs')
            ->setPaginatorPageSize(10);

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->HideOnForm(),
            TextField::new('Username'),
            TextField::new('Email')
                ,
            TextEditorField::new('Password')
                ->HideOnform(),
            TextField::new('ProfilePicture'),
            TextField::new('ProfileCover'),
            ArrayField::new('roles'),
            TextField::new('Bio'),
        ];
    }
}
