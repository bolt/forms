<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

class FieldOptions
{
    public static function get(array $field): array
    {
        return $field['options'];
    }
}
