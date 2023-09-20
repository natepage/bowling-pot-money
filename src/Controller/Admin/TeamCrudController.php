<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Team;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');

        yield CurrencyField::new('currency')
            ->showCode(true)
            ->showName(false)
            ->showSymbol(false);

        yield from parent::configureFields($pageName);

        yield AssociationField::new('createdBy')
            ->setCrudController(UserCrudController::class)
            ->hideOnIndex()
            ->hideOnForm();

        yield AssociationField::new('updatedBy')
            ->setCrudController(UserCrudController::class)
            ->hideOnIndex()
            ->hideOnForm();
    }
}