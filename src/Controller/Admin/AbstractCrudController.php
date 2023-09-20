<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController as EasyAdminAbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

abstract class AbstractCrudController extends EasyAdminAbstractCrudController
{
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}