<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Bolt\BoltForms\Form\CaptchaType;
use Bolt\BoltForms\Form\ContenttypeType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;

class FieldType
{
    public static function get($field): string
    {
        switch ($field['type']) {
            case 'captcha':
                $type = CaptchaType::class;
                break;
            case 'birthday':
                $type = BirthdayType::class;
                break;
            case 'button':
                $type = ButtonType::class;
                break;
            case 'checkbox':
                $type = CheckboxType::class;
                break;
            case 'choice':
                $type = ChoiceType::class;
                break;
            case 'collection':
                $type = CollectionType::class;
                break;
            case 'color':
                $type = ColorType::class;
                break;
            case 'contenttype':
                $type = ContenttypeType::class;
                break;
            case 'country':
                $type = CountryType::class;
                break;
            case 'currency':
                $type = CurrencyType::class;
                break;
            case 'dateinterval':
                $type = DateIntervalType::class;
                break;
            case 'datetime':
                $type = DateTimeType::class;
                break;
            case 'date':
                $type = DateType::class;
                break;
            case 'email':
                $type = EmailType::class;
                break;
            case 'file':
                $type = FileType::class;
                break;
            // case 'form':
            //     $type = FormType::class;
            //     break;
            case 'hidden':
                $type = HiddenType::class;
                break;
            case 'integer':
                $type = IntegerType::class;
                break;
            case 'language':
                $type = LanguageType::class;
                break;
            case 'locale':
                $type = LocaleType::class;
                break;
            case 'money':
                $type = MoneyType::class;
                break;
            case 'number':
                $type = NumberType::class;
                break;
            case 'password':
                $type = PasswordType::class;
                break;
            case 'percent':
                $type = PercentType::class;
                break;
            case 'radio':
                $type = RadioType::class;
                break;
            case 'range':
                $type = RangeType::class;
                break;
            case 'repeated':
                $type = RepeatedType::class;
                break;
            case 'reset':
                $type = ResetType::class;
                break;
            case 'search':
                $type = SearchType::class;
                break;
            case 'submit':
                $type = SubmitType::class;
                break;
            case 'tel':
                $type = TelType::class;
                break;
            case 'text':
                $type = TextType::class;
                break;
            case 'textarea':
                $type = TextareaType::class;
                break;
            case 'time':
                $type = TimeType::class;
                break;
            case 'timezone':
                $type = TimezoneType::class;
                break;
            case 'url':
                $type = UrlType::class;
                break;
            case 'week':
                $type = WeekType::class;
                break;
            default:
                $type = TextType::class;
                break;
        }

        return $type;
    }
}
