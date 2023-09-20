<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Enum\TeamMemberAccessLevelEnum;
use App\Entity\TeamMember;
use App\Infrastructure\EasyAdmin\Field\BackedEnumField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

final class TeamMemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TeamMember::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions
            ->disable(Action::DELETE, Action::EDIT, Action::NEW);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('team')
            ->autocomplete()
            ->setCrudController(TeamCrudController::class);

        yield AssociationField::new('user')
            ->autocomplete()
            ->setCrudController(UserCrudController::class);

        yield BackedEnumField::new('accessLevel')
            ->setEnumClass(TeamMemberAccessLevelEnum::class);

        yield CurrencyField::new('currency')
            ->showCode(true)
            ->showName(false)
            ->showSymbol(false);

        yield MoneyField::new('balance')
            ->setCurrencyPropertyPath('currency')
            ->hideOnForm();

        yield NumberField::new('sequentialNumber')
            ->hideOnForm();

        yield from parent::configureFields($pageName);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);
        $filters
            ->add(EntityFilter::new('team'))
            ->add(EntityFilter::new('user'));

        return $filters;
    }
}