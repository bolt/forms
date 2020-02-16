<?php


namespace Bolt\BoltForms;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormBuilder as SymfonyFormBuilder;

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

        foreach($formConfig['fields'] as $name => $field) {
            $this->addField($formBuilder, $name, $field);
        }

        $form = $formBuilder->getForm();

        return $form;
    }

    private function addField(SymfonyFormBuilder $formBuilder, string $name, array $field)
    {
        $type = $this->getType($field);
        $options = $this->getOptions($field);

        $formBuilder->add($name, $type, $options);

    }

    private function getType($field): string
    {
        switch ($field['type']) {
            case 'textarea':
                $type = TextareaType::class;
                break;
            case 'email':
                $type = EmailType::class;
                break;
            case 'file':
                $type = FileType::class;
                break;
            case 'submit':
                $type = SubmitType::class;
                break;
            case 'choice':
                $type = ChoiceType::class;

                break;
            case 'text':
            default:
                $type = TextType::class;
                break;
        }

        return $type;
    }

    private function getOptions(array $field): array
    {
        $options = $field['options'];

        return $options;
    }

}