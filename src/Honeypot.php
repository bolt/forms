<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder as SymfonyFormBuilder;

class Honeypot
{
    public function __construct(
        private readonly string $formName,
        private readonly ?SymfonyFormBuilder $formBuilder = null
    ) {
    }

    public function addField(): void
    {
        $fieldname = $this->generateFieldName();

        $options = [
            'required' => false,
            'attr' => [
                'tabindex' => '-1',
                'autocomplete' => 'off',
            ],
        ];

        $this->formBuilder->add($fieldname, TextType::class, $options);
    }

    public function generateFieldName($withFormName = false): string
    {
        $seed = preg_replace('/[^0-9]/', '', md5($_SERVER['APP_SECRET'] . $_SERVER['REMOTE_ADDR']));
        mt_srand($seed % PHP_INT_MAX);

        $values = ['field', 'name', 'object', 'string', 'value', 'input', 'required', 'optional', 'first', 'last', 'phone', 'telephone', 'fax', 'twitter', 'contact', 'approve', 'city', 'state', 'province', 'company', 'card', 'number', 'recipient', 'processor', 'transaction', 'domain', 'date', 'type'];

        if ($withFormName) {
            $parts = [$this->formName];
        } else {
            $parts = [];
        }

        // Note: we're using mt_rand here, because we explicitly want
        // pseudo-random results, to make sure it's reproducible.
        for ($i = 0; $i <= mt_rand(2, 3); $i++) {
            $parts[] = $values[mt_rand(0, \count($values) - 1)];
        }

        return implode('_', $parts);
    }

    public function isenabled(): bool
    {
        return $this->config->get('honeypot', false);
    }
}
