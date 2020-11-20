<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FieldType
{
    public static function get($field): string
    {
        switch ($field['type']) {
            case 'textarea':
                $type = TextareaType::class;
                break;
            case 'email':
                $type = EmailType::class;
                break;
            case 'file':
                $type = FileType::class;
                break;
            case 'submit':
                $type = SubmitType::class;
                break;
            case 'choice':
                $type = ChoiceType::class;
                break;
            case 'checkbox':
                $type = CheckboxType::class;
                break;
            case 'date':
                $type = DateType::class;
                break;
            case 'dateinterval':
                $type = DateIntervalType::class;
                break;
            case 'datetime':
                $type = DateTimeType::class;
                break;
            case 'country':
                $type = CountryType::class;
                break;
            case 'text':
            default:
                $type = TextType::class;
                break;
        }

        return $type;
    }
}
