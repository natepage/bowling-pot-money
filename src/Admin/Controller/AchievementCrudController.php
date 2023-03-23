<?php
declare(strict_types=1);

namespace App\Admin\Controller;

use App\Entity\Achievement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

final class AchievementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Achievement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');

        yield MoneyField::new('cost')
            ->setCurrencyPropertyPath('currency');

        yield AssociationField::new('team')
            ->setCrudController(TeamCrudController::class)
            ->autocomplete();

        yield from parent::configureFields($pageName);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);
        $filters
            ->add(EntityFilter::new('team'));

        return $filters;
    }
}