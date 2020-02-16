<?php

namespace Bolt\BoltForms\Factory;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            case 'text':
            default:
                $type = TextType::class;
                break;
        }

        return $type;
    }
}