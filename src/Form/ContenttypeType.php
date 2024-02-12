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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Cache\CacheInterface;

class ContenttypeType extends AbstractType
{
    private $query;
    private $cache;

    public function __construct(Query $query, CacheInterface $cache)
    {
        $this->query = $query;
        $this->cache = $cache;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => [],
            'params'  => $this->getDefaultParams(),
        ]);
    }

    private function getDefaultParams(): array
    {
        return [
            'contenttype' => 'pages',
            'label'       => 'title',
            'value'       => 'slug',
            'limit'       => 4,
            'sort'        => 'title',
            'criteria'    => [],
            'cache'       => false,
            'cache_lifetime' => 3600
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($options) {
                $form = $event->getForm();
                $params = array_merge($this->getDefaultParams(), $options['params']);

                $criteria = [
                    'status' => Statuses::PUBLISHED,
                    'limit'  => $params['limit'],
                    'order'  => $params['sort'],
                ];

                $criteria = array_merge($criteria, $params['criteria']);

                $entries = $this->query->getContent($params['contenttype'], $criteria);

                $choices = [];
                if ($params['cache']) {
                    $cachedChoices = $this->cache->getItem('choices');

                    if (!$cachedChoices->isHit()) {
                        foreach ($entries->getCurrentPageResults() as $entry) {
                            $value = $entry->getFieldValue($params['value']);
                            $label = $entry->getFieldValue($params['label']);
                            $choices[$label] = $value;
                        }
                        $cachedChoices->set($choices);
                        $cachedChoices->expiresAfter($params['cache_lifetime']);
                        $this->cache->save($cachedChoices);
                    }

                    $choices = $cachedChoices->get();
                } else {
                    foreach ($entries->getCurrentPageResults() as $entry) {
                        $value = $entry->getFieldValue($params['value']);
                        $label = $entry->getFieldValue($params['label']);
                        $choices[$label] = $value;
                    }
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
