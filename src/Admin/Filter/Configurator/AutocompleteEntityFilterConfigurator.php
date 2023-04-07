<?php
declare(strict_types=1);

namespace App\Admin\Filter\Configurator;

use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDto;
use EasyCorp\Bundle\EasyAdminBundle\Factory\ControllerFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\CrudAutocompleteType;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

final class AutocompleteEntityFilterConfigurator implements FilterConfiguratorInterface
{
    public function __construct(
        private readonly AdminUrlGenerator $adminUrlGenerator,
        private readonly ControllerFactory $controllerFactory
    ) {
    }

    public function configure(FilterDto $filterDto, ?FieldDto $fieldDto, EntityDto $entityDto, AdminContext $context): void
    {
        // Remove if/once fix to inject $fieldDto is merged/released
        // https://github.com/EasyCorp/EasyAdminBundle/pull/4978
        $fieldDto = $this->getFieldDto($filterDto, $fieldDto, $context);

        // Configure only if field is autocomplete
        if ($fieldDto === null || $fieldDto->getCustomOption(AssociationField::OPTION_AUTOCOMPLETE) !== true) {
            return;
        }

        $autocompleteUrl = $this->generateAutocompleteUrl($filterDto, $fieldDto, $context);

        $filterDto->setFormTypeOptionIfNotSet('value_type', CrudAutocompleteType::class);
        $filterDto->setFormTypeOptionIfNotSet('value_type_options.attr.data-ea-autocomplete-endpoint-url', $autocompleteUrl);
    }

    public function supports(FilterDto $filterDto, ?FieldDto $fieldDto, EntityDto $entityDto, AdminContext $context): bool
    {
        return $filterDto->getFqcn() === EntityFilter::class;
    }

    private function generateAutocompleteUrl(FilterDto $filterDto, FieldDto $fieldDto, AdminContext $context): string
    {
        return $this->adminUrlGenerator
            ->unsetAll()
            ->set(EA::PAGE, 1)
            ->setController($fieldDto->getCustomOption(AssociationField::OPTION_CRUD_CONTROLLER))
            ->setAction(AssociationField::OPTION_AUTOCOMPLETE)
            ->set(AssociationField::PARAM_AUTOCOMPLETE_CONTEXT, [
                EA::CRUD_CONTROLLER_FQCN => $context->getCrud()->getControllerFqcn(),
                'propertyName' => $filterDto->getProperty(),
                'originatingPage' => $context->getCrud()->getCurrentPage() ?? Crud::PAGE_INDEX,
            ])
            ->generateUrl();
    }

    private function getFieldDto(FilterDto $filterDto, ?FieldDto $fieldDto, AdminContext $context): ?FieldDto
    {
        if ($fieldDto !== null) {
            return $fieldDto;
        }

        $crudController = $this->controllerFactory->getCrudControllerInstance(
            $context->getCrud()->getControllerFqcn(),
            Crud::PAGE_INDEX,
            $context->getRequest()
        );

        if ($crudController === null) {
            return null;
        }

        $fields = FieldCollection::new($crudController->configureFields(Crud::PAGE_INDEX));

        return $fields->getByProperty($filterDto->getProperty());
    }
}