<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\BoltForms\Factory\FieldOptions;
use Bolt\BoltForms\Factory\FieldType;
use Bolt\BoltForms\EventSubscriber\SymfonyFormProxySubscriber;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder as SymfonyFormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Tightenco\Collect\Support\Collection;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class FormBuilder
{
    /** @var FormFactory */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function build(string $formName, Collection $config, EventDispatcherInterface $eventDispatcher): Form
    {
        /** @var SymfonyFormBuilder $formBuilder */
        $formBuilder = $this->formFactory->createNamedBuilder($formName, FormType::class, [], [
            'attr' => [
                'class' => 'boltforms',
            ],
        ]);
        $formBuilder->addEventSubscriber(new SymfonyFormProxySubscriber($eventDispatcher));

        foreach ($config->get($formName)['fields'] as $name => $field) {
            $this->addField($formBuilder, $name, $field);
        }

        $this->addHoneypot($formName, $formBuilder, $config);
        return $formBuilder->getForm();
    }

    private function addField(SymfonyFormBuilder $formBuilder, string $name, array $field): void
    {
        $type = FieldType::get($field);
        $options = FieldOptions::get($name, $field);

        $formBuilder->add($name, $type, $options);
    }

    private function addHoneypot(string $formName, SymfonyFormBuilder $formBuilder, Collection $config): void
    {
        if ($config->get('honeypot', false)) {
            $honeypot = new Honeypot($formName, $formBuilder);
            $honeypot->addField();
        }
    }
}
