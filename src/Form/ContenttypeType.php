<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Form;

use Bolt\Enum\Statuses;
use Bolt\Storage\Query;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContenttypeType extends AbstractType
{
    public function __construct(
        private Query $query
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [],
            'params' => $this->getDefaultParams(),
        ]);
    }

    private function getDefaultParams(): array
    {
        return [
            'contenttype' => 'pages',
            'label' => 'title',
            'value' => 'slug',
            'limit' => 4,
            'sort' => 'title',
            'criteria' => [],
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
                $form = $event->getForm();
                $params = array_merge($this->getDefaultParams(), $options['params']);

                $criteria = [
                    'status' => Statuses::PUBLISHED,
                    'limit' => $params['limit'],
                    'order' => $params['sort'],
                ];

                $criteria = array_merge($criteria, $params['criteria']);

                $entries = $this->query->getContent($params['contenttype'], $criteria);

                $choices = [];
                foreach ($entries->getCurrentPageResults() as $entry) {
                    $value = $entry->getFieldValue($params['value']);
                    $label = $entry->getFieldValue($params['label']);
                    $choices[$label] = $value;
                }

                $options['choices'] = $choices;
                unset($options['params']);

                $parent = $form->getParent();
                $name = $form->getConfig()->getName();
                $parent->add($name, ChoiceType::class, $options);
            })
        ;
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
