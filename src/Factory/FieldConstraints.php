<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Symfony\Component\Form\Exception\RuntimeException;

class FieldConstraints
{
    public const SF_NAMESPACE = '\\Symfony\\Component\\Validator\\Constraints\\';

    public static function get(string $formName, array $field): array
    {
        if (! \array_key_exists('constraints', $field)) {
            return [];
        }

        $result = [];
        $class = null;

        foreach ($field['constraints'] as $item) {
            $inputType = \gettype($item);

            if ($inputType === 'string') {
                $class = self::getClassFromString($formName, $item);
            } elseif ($inputType === 'array') {
                $class = self::getClassFromArray($formName, $item);
            } else {
                throw new RuntimeException(sprintf("Constraint for Field '%s' must be string or array. '%s' given.", $formName, $inputType));
            }

            $result[] = $class;
        }

        return $result;
    }

    private static function getClassFromString(string $formName, string $input, array $params = []): object
    {
        $className = self::SF_NAMESPACE . $input;

        if (! class_exists($className)) {
            $message = sprintf(
                "Constraint for Field '%s' must be valid constraint Class in the '%s' namespace. '%s' given.",
                $formName,
                self::SF_NAMESPACE,
                $input
            );
            throw new RuntimeException($message);
        }

        return new $className($params);
    }

    private static function getClassFromArray(string $formName, array $input): object
    {
        return self::getClassFromString($formName, (string) key($input), current($input));
    }
}
