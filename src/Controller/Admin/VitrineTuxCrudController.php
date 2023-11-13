<?php

namespace App\Controller\Admin;

use App\Entity\VitrineTux;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VitrineTuxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VitrineTux::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            AssociationField::new('membretux'),
            BooleanField::new('ispublic')
                ->onlyOnForms()
                ->hideWhenCreating(),
            TextField::new('name'),

            AssociationField::new('cartestux')
                ->onlyOnForms()
                // on ne souhaite pas gérer l'association entre les
                // [objets] et la [galerie] dès la crétion de la
                // [galerie]
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/classeurtux_cartestux.html.twig')
                // Ajout possible seulement pour des [objets] qui
                // appartiennent même propriétaire de l'[inventaire]
                // que le [createur] de la [galerie]
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        // récupération de l'instance courante de [galerie]
                        $currentVitrine = $this->getContext()->getEntity()->getInstance();
                        $owner = $currentVitrine->get();
                        $memberId = $owner->getId();
                        // charge les seuls [objets] dont le 'owner' de l'[inventaire] est le [createur] de la galerie
                        $queryBuilder->leftJoin('entity.classeurtux', 'i')
                            ->leftJoin('i.owner', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);    
                        return $queryBuilder;
                    }
                   ),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
    
}
