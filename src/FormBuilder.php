<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\BoltForms\Factory\FieldConstraints;
use Bolt\BoltForms\Factory\FieldOptions;
use Bolt\BoltForms\Factory\FieldType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder as SymfonyFormBuilder;
use Symfony\Component\Form\FormFactoryInterface;

class FormBuilder
{
    /** @var FormFactory */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function build(string $formName, array $formConfig): Form
    {
        /** @var SymfonyFormBuilder $formBuilder */
        $formBuilder = $this->formFactory->createNamedBuilder($formName);

        foreach ($formConfig['fields'] as $name => $field) {
            $this->addField($formBuilder, $name, $field);
        }

        return $formBuilder->getForm();
    }

    private function addField(SymfonyFormBuilder $formBuilder, string $name, array $field): void
    {
        $type = FieldType::get($field);
        $options = FieldOptions::get($field);
        $constraints = FieldConstraints::get($name, $field);

        $formBuilder->add($name, $type, $options);

        if ($constraints) {
            dump($constraints);
        }
    }
}
