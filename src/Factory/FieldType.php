<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Bolt\BoltForms\Form\CaptchaType;
use Bolt\BoltForms\Form\ContenttypeType;
use Gregwar\CaptchaBundle\Type\CaptchaType as GregwarCaptchaType;
use PixelOpen\CloudflareTurnstileBundle\Type\TurnstileType;
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
    public static function get(array $field): string
    {
        $type = match ($field['type']) {
            'captcha' => CaptchaType::class,
            'birthday' => BirthdayType::class,
            'button' => ButtonType::class,
            'checkbox' => CheckboxType::class,
            'choice' => ChoiceType::class,
            'collection' => CollectionType::class,
            'color' => ColorType::class,
            'contenttype' => ContenttypeType::class,
            'country' => CountryType::class,
            'currency' => CurrencyType::class,
            'dateinterval' => DateIntervalType::class,
            'datetime' => DateTimeType::class,
            'date' => DateType::class,
            'email' => EmailType::class,
            'file' => FileType::class,
            'hidden' => HiddenType::class,
            'integer' => IntegerType::class,
            'language' => LanguageType::class,
            'locale' => LocaleType::class,
            'money' => MoneyType::class,
            'number' => NumberType::class,
            'password' => PasswordType::class,
            'percent' => PercentType::class,
            'radio' => RadioType::class,
            'range' => RangeType::class,
            'repeated' => RepeatedType::class,
            'reset' => ResetType::class,
            'search' => SearchType::class,
            'submit' => SubmitType::class,
            'tel' => TelType::class,
            'text' => TextType::class,
            'textarea' => TextareaType::class,
            'time' => TimeType::class,
            'timezone' => TimezoneType::class,
            'url' => UrlType::class,
            'week' => WeekType::class,
            'gregwarCaptcha' => GregwarCaptchaType::class,
            'turnstileCaptcha' => TurnstileType::class,
            default => TextType::class,
        };

        return $type;
    }
}
