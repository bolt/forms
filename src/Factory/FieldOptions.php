<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

class FieldOptions
{
    public static function get(string $formName, array $field): array
    {
        if (! array_key_exists('options', $field)) {
            return [];
        }

        $options = $field['options'];

        $options['constraints'] = FieldConstraints::get($formName, $options);

        if ($field['type'] === 'submit') {
            unset($options['constraints']);
        }

        return $options;
    }
}
