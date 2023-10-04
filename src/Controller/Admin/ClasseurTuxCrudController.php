<?php

namespace App\Controller\Admin;

use App\Entity\ClasseurTux;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClasseurTuxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClasseurTux::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    /*
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->overrideTemplate('crud/index','admin/crud/classeur_index.html.twig');
    }
    */
}
