<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Enum\TeamMemberAccessLevelEnum;
use App\Form\Dto\CreateTeamInviteDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateTeamInviteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('accessLevel', EnumType::class, [
                'class' => TeamMemberAccessLevelEnum::class,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create invite',
                'row_attr' => [
                    'class' => 'mb-3 text-end',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTeamInviteDto::class,
        ]);
    }
}