<?php

namespace Bolt\BoltForms\Factory;

use http\Exception\RuntimeException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraint;

class FieldConstraints
{
    const SF_NAMESPACE = '\\Symfony\\Component\\Validator\\Constraints\\';

    /**
     * @param array $field
     */
    public static function get(string $formName, array $field): ?array
    {
        if (!array_key_exists('constraints', $field)) {
            return null;
        }

        $result = [];

        $class = null;
        $params = null;

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

    /**
     * @param mixed $params
     */
    private static function getClassFromArray(array $input): object
    {
        return self::getClassFromString(key($input), current($input));
    }
}