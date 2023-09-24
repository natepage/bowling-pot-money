<?php
declare(strict_types=1);

namespace App\Form;

use App\Form\Dto\SessionCreateDto;
use App\Repository\TeamMemberRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SessionCreateForm extends AbstractType
{
    public function __construct(
        private readonly TeamMemberRepository $teamMemberRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $memberChoices = [];
        $members = $this->teamMemberRepository->findByTeamIdWithTeamAndUser($options['teamId']);
        foreach ($members as $member) {
            $memberChoices[$member->getUser()->getName()] = $member->getId();
        }

        $builder->add('memberIds', ChoiceType::class, [
            'choices' => $memberChoices,
            'multiple' => true,
            'expanded' => true,
        ]);

        $builder->add('submit', SubmitType::class, [
            'label' => 'Yes',
            'attr' => [
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SessionCreateDto::class,
            'teamId' => null,
        ]);
    }
}