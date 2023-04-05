<?php
declare(strict_types=1);

namespace App\Admin\Controller;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

final class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions
            ->disable(Action::DELETE);

        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);
        $crud
            ->setDefaultSort(['name' => 'ASC']);

        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AvatarField::new('picture');
        yield TextField::new('name');
        yield EmailField::new('email')
            ->hideOnForm();

        yield TextField::new('sub')
            ->hideOnForm();

        yield BooleanField::new('emailVerified')
            ->hideOnForm()
            ->renderAsSwitch(false);

        yield from parent::configureFields($pageName);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);
        $filters
            ->add(TextFilter::new('email'))
            ->add(BooleanFilter::new('emailVerified'))
            ->add(TextFilter::new('name'))
            ->add(TextFilter::new('sub'));

        return $filters;
    }
}