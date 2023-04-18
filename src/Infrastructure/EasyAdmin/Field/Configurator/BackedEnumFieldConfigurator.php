<?php
declare(strict_types=1);

namespace App\Infrastructure\EasyAdmin\Field\Configurator;

use App\Infrastructure\EasyAdmin\Field\BackedEnumField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;

final class BackedEnumFieldConfigurator implements FieldConfiguratorInterface
{
    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        $enum = $field->getValue();
        if ($enum instanceof \BackedEnum === false) {
            return;
        }

        $field->setFormattedValue($enum->value);
        $field->setValue($enum->value);
    }

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return $field->getFieldFqcn() === BackedEnumField::class;
    }
}
