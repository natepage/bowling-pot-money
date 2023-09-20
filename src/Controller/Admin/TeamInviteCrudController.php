<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Enum\TeamInviteStatusEnum;
use App\Entity\Enum\TeamMemberAccessLevelEnum;
use App\Entity\TeamInvite;
use App\Infrastructure\EasyAdmin\Field\BackedEnumField;
use App\Infrastructure\EasyAdmin\Helper\ChoiceHelper;
use App\Team\TeamInvite\TeamInvitePersister;
use App\Team\TeamInvite\TeamInviteSender;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

final class TeamInviteCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly TeamInvitePersister $teamInvitePersister,
        private readonly TeamInviteSender $teamInviteSender
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return TeamInvite::class;
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

        yield TextField::new('email');

        yield BackedEnumField::new('accessLevel')
            ->setEnumClass(TeamMemberAccessLevelEnum::class);

        yield BackedEnumField::new('status')
            ->setEnumClass(TeamInviteStatusEnum::class)
            ->hideOnForm();

        yield from parent::configureFields($pageName);
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters = parent::configureFilters($filters);
        $filters
            ->add(TextFilter::new('email'))
            ->add(ChoiceFilter::new('accessLevel')
                ->setChoices(ChoiceHelper::formatForAdminSelect(TeamMemberAccessLevelEnum::cases())))
            ->add(ChoiceFilter::new('status')
                ->setChoices(ChoiceHelper::formatForAdminSelect(TeamInviteStatusEnum::cases())));

        return $filters;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->teamInvitePersister->persist($entityInstance);
        $this->teamInviteSender->send($entityInstance);
    }
}