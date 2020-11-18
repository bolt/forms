<?php

namespace Bolt\BoltForms\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaptchaType extends HiddenType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['captcha_type'] = $options['captcha_type'];
        $view->vars['hcaptcha_public_key'] = $options['hcaptcha_public_key'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'captcha_type' => '',
            'hcaptcha_public_key' => '',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'captcha';
    }
}