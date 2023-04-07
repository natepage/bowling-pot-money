<?php
declare(strict_types=1);

namespace App\Infrastructure\EasyAdmin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class BackedEnumField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplateName('crud/field/text')
            ->setFormType(EnumType::class)
            ->addCssClass('field-text')
            ->setDefaultColumns('col-md-6 col-xxl-5');
    }

    public function setEnumClass(string $class): self
    {
        $this->setFormTypeOption('class', $class);
        return $this;
    }
}
