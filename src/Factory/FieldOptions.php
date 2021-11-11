<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Bolt\BoltForms\Validator\Constraints\Hcaptcha;
use Bolt\BoltForms\Validator\Constraints\Recaptcha;
use Tightenco\Collect\Support\Collection;

class FieldOptions
{
    public static function get(string $formName, array $field, Collection $config): array
    {
        if (! \array_key_exists('options', $field)) {
            return [];
        }

        $options = $field['options'];

        $options['constraints'] = FieldConstraints::get($formName, $options);

        if (in_array($field['type'], ['submit', 'button', 'reset'], true)) {
            unset($options['constraints']);
        } elseif ($field['type'] === 'captcha') {
            if ($config->has('hcaptcha')) {
                $options['hcaptcha_public_key'] = $config['hcaptcha']['public_key'];

                if (isset($config['hcaptcha']['theme'])) {
                    $options['hcaptcha_theme'] = $config['hcaptcha']['theme'];
                }
            }

            if ($config->has('recaptcha')) {
                $options['recaptcha_public_key'] = $config['recaptcha']['public_key'];

                if (isset($config['recaptcha']['theme'])) {
                    $options['recaptcha_theme'] = $config['recaptcha']['theme'];
                }
            }

            unset($options['constraints']);

            if (isset($options['captcha_type'])) {
                switch ($options['captcha_type']) {
                    case 'hcaptcha':
                        $options['constraints'] = [
                            new Hcaptcha($config['hcaptcha']['public_key'], $config['hcaptcha']['private_key']),
                        ];
                        break;

                    case 'recaptcha_v3':
                        $options['constraints'] = [
                            new Recaptcha($config['recaptcha']['public_key'], $config['recaptcha']['private_key'], $config['recaptcha']['recaptcha_v3_threshold'], $config['recaptcha']['recaptcha_v3_fail_message']),
                        ];
                        break;
                    case 'recaptcha_v2':
                        $options['constraints'] = [
                            new Recaptcha($config['recaptcha']['public_key'], $config['recaptcha']['private_key']),
                        ];
                        break;
                }
            }
        }

        return $options;
    }
}
