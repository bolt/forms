<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

class FieldConstraints
{
    public const SF_NAMESPACE = '\\Symfony\\Component\\Validator\\Constraints\\';

    public static function get(string $formName, array $field): ?array
    {
        if (! array_key_exists('constraints', $field)) {
            return null;
        }

        $result = [];
        $class = null;

        foreach ($field['constraints'] as $item) {
            $inputType = gettype($item);

            if ($inputType === 'string') {
                $class = static::getClassFromString($item);
            } elseif ($inputType === 'array') {
                $class = static::getClassFromArray($item);
            }

            $result[] = $class;
        }

        return $result;
    }

    private static function getClassFromString(string $input, array $params = []): object
    {
        $className = self::SF_NAMESPACE . $input;
        return new $className($params);
    }

    private static function getClassFromArray(array $input): object
    {
        return self::getClassFromString(key($input), current($input));
    }
}
