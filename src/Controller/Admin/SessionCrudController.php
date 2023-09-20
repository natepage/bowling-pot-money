<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use App\Infrastructure\EasyAdmin\Field\BackedEnumField;
use App\Infrastructure\EasyAdmin\Helper\ChoiceHelper;
use App\Session\SessionManager;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

final class SessionCrudController extends AbstractCrudController
{
    public function __construct(private readonly SessionManager $sessionManager)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud = parent::configureCrud($crud);
        $crud
            ->setDefaultSort(['createdAt' => 'DESC']);

        return $crud;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('team')
            ->autocomplete()
            ->setCrudController(TeamCrudController::class);

        yield BackedEnumField::new('status')
            ->setEnumClass(SessionStatusEnum::class)
            ->hideOnForm();

        yield from parent::configureFields($pageName);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);
        $filters
            ->add(EntityFilter::new('team'))
            ->add(ChoiceFilter::new('status')
                ->setChoices(ChoiceHelper::formatForAdminSelect(SessionStatusEnum::cases())));

        return $filters;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->sessionManager->openSession($entityInstance->getTeam());
    }
}