<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Tightenco\Collect\Support\Collection;

class FieldOptions
{
    public static function get(string $formName, array $field, Collection $config): array
    {
        if (! array_key_exists('options', $field)) {
            return [];
        }

        $options = $field['options'];

        $options['constraints'] = FieldConstraints::get($formName, $options);

        if ($field['type'] === 'submit') {
            unset($options['constraints']);
        } else if ($field['type'] === 'captcha') {
            if (isset($config['hcaptcha']['public_key'])) {
                $options['hcaptcha_public_key'] = $config['hcaptcha']['public_key'];
            }
        }

        return $options;
    }
}
