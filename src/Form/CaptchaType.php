<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaptchaType extends HiddenType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['captcha_type'] = $options['captcha_type'];
        $view->vars['captcha_invisible'] = $options['captcha_invisible'];
        $view->vars['hcaptcha_public_key'] = $options['hcaptcha_public_key'];
        $view->vars['hcaptcha_theme'] = $options['hcaptcha_theme'];
        $view->vars['recaptcha_public_key'] = $options['recaptcha_public_key'];
        $view->vars['recaptcha_theme'] = $options['recaptcha_theme'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'captcha_type' => '',
            'captcha_invisible' => false,
            'hcaptcha_theme' => 'light',
            'recaptcha_theme' => 'light',
            'hcaptcha_public_key' => '',
            'recaptcha_public_key' => ''
        ]);
    }

    public function getBlockPrefix()
    {
        return 'captcha';
    }
}
