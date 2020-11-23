<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Bolt\BoltForms\Validator\Constraints\Hcaptcha;
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
        } elseif ($field['type'] === 'captcha') {
            if (isset($config['hcaptcha']['public_key'])) {
                $options['hcaptcha_public_key'] = $config['hcaptcha']['public_key'];
            }

            unset($options['constraints']);
            $options['constraints'] = [
                new Hcaptcha($config['hcaptcha']['public_key'], $config['hcaptcha']['private_key'])
            ];
        }

        return $options;
    }
}
