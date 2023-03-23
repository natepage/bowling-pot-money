<?php
declare(strict_types=1);

namespace App\Admin\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController as EasyAdminAbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

abstract class AbstractCrudController extends EasyAdminAbstractCrudController
{
    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm();
    }
}