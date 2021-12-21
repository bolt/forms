<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\BoltForms\EventSubscriber\SymfonyFormProxySubscriber;
use Bolt\BoltForms\Factory\FieldOptions;
use Bolt\BoltForms\Factory\FieldType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder as SymfonyFormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Tightenco\Collect\Support\Collection;

class FormBuilder
{
    /** @var FormFactory */
    private $formFactory;

    /** @var bool */
    private $hasRecaptchaV2Invisible = false;

    /** @var bool */
    private $hasRecaptchaV3 = false;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function build(string $formName, array $data, Collection $config, EventDispatcherInterface $eventDispatcher): Form
    {
        /** @var SymfonyFormBuilder $formBuilder */
        $formBuilder = $this->formFactory->createNamedBuilder($formName, FormType::class, [], [
            'attr' => [
                'class' => 'boltforms',
            ],
        ]);
        $formBuilder->addEventSubscriber(new SymfonyFormProxySubscriber($eventDispatcher));

        foreach ($config->get($formName)['fields'] as $name => $field) {
            // If we passed in a default value, set it as the Field's `data`-value
            if (array_key_exists($name, $data)) {
                $field['options']['data'] = $data[$name];
            }

            if ($field['type'] === 'captcha') {
                $this->addCaptchaField($formBuilder, $name, $field, $config);
            } else {
                $this->addField($formBuilder, $name, $field, $config, $formName);
            }
        }

        $this->addHoneypot($formName, $formBuilder, $config);

        return $formBuilder->getForm();
    }

    private function addCaptchaField(SymfonyFormBuilder $formBuilder, string $name, array $field, Collection $config): void
    {
        // Can't do anything if we don't know what type of CAPTCHA is required
        if (! isset($field['options']['captcha_type'])) {
            throw new \Exception(sprintf('The CAPTCHA field \'%s\' does not have a captcha_type option defined.', $name));
        }

        // If we're using reCaptcha V3 or V2 invisible, we need to add some attributes to the submit button
        // As we're adding each field, if it's a reCaptcha V3, flag that we're using it

        switch ($field['options']['captcha_type']) {
            case 'recaptcha_v3':
                if (! $config->has('recaptcha') || ! (bool) ($config->get('recaptcha')['enabled'])) {
                    // Allow users to simply disable CAPTCHA protection by flipping the flag
                    return;
                }

                $this->hasRecaptchaV3 = true;

                if (! isset($config['recaptcha']['public_key'])) {
                    throw new \Exception('You must specify your site key using the public_key option under the recaptcha node in your forms config.');
                }

                if (! isset($config['recaptcha']['private_key'])) {
                    throw new \Exception('You must specify your secret key using the private_key option under the recaptcha node in your forms config.');
                }
                break;

            case 'recaptcha_v2':
                if (! $config->has('recaptcha') || ! (bool) ($config->get('recaptcha')['enabled'])) {
                    // Allow users to simply disable CAPTCHA protection by flipping the flag
                    return;
                }

                $this->hasRecaptchaV2Invisible = isset($field['options']['captcha_invisible']) && (bool) ($field['options']['captcha_invisible']);

                if (! isset($config['recaptcha']['public_key'])) {
                    throw new \Exception('You must specify your site key using the public_key option under the recaptcha node in your forms config.');
                }

                if (! isset($config['recaptcha']['private_key'])) {
                    throw new \Exception('You must specify your secret key using the private_key option under the recaptcha node in your forms config.');
                }
                break;

            case 'hcaptcha':
                if (! $config->has('hcaptcha') || ! (bool) ($config->get('hcaptcha')['enabled'])) {
                    // Allow users to simply disable CAPTCHA protection by flipping the flag
                    return;
                }

                if (! isset($config['hcaptcha']['public_key'])) {
                    throw new \Exception('You must specify your site key using the public_key option under the hcaptcha node in your forms config.');
                }

                if (! isset($config['hcaptcha']['private_key'])) {
                    throw new \Exception('You must specify your secret key using the private_key option under the hcaptcha node in your forms config.');
                }
                break;

            default:
                throw new \Exception(sprintf('The captcha_type value \'%s\' is not supported on the \'%s\' field.', $field['options']['captcha_type'], $name));
        }

        $type = FieldType::get($field);
        $options = FieldOptions::get($name, $field, $config);

        $formBuilder->add($name, $type, $options);
    }

    private function addField(SymfonyFormBuilder $formBuilder, string $name, array $field, Collection $config, $formName): void
    {
        // If we're using reCaptcha V3 or V2 invisible, we need to add some attributes to the submit button
        // If we're adding a submit button, attach the attributes if we're using reCaptcha v3 or v2 invisible
        if ($field['type'] === 'submit' && ($this->hasRecaptchaV3 || $this->hasRecaptchaV2Invisible)) {
            $attr = [];

            if ($this->hasRecaptchaV3) {
                //Fix for allowing multiple recaptcha v3 forms on a single page

                //Used to converted snake case into camel case
                $splitFormName = explode("_", $formName);
                if(count($splitFormName) > 1){
                    foreach($splitFormName as $item){
                        $item = ucfirst($item);
                    }
                    $formNameJs = join(" ", $splitFormName);
                } else {
                    $formNameJs = ucfirst($formName);
                }
                $attr = [
                    'class' => 'g-recaptcha',
                    'data-sitekey' => $config['recaptcha']['public_key'],
                    'data-callback' => 'onRecaptchaSubmitted' . $formNameJs,
                    // pass the name of the form as the Action for reCAPTCHA v3
                    'data-action' => $formName,
                ];                
            } elseif ($this->hasRecaptchaV2Invisible) {
                $attr = [
                    'class' => 'g-recaptcha',
                    'data-sitekey' => $config['recaptcha']['public_key'],
                    'data-callback' => 'onRecaptchaSubmitted',
                    'data-size' => 'invisible',
                ];
            }

            // Merge our attributes with any existing ones defined in the config
            // If a CSS class is already defined, append our new class instead of merging so it doesn't end up as an
            // array instead of a string
            if (isset($field['options']['attr']['class'])) {
                $attr['class'] = sprintf('%s %s', $field['options']['attr']['class'], $attr['class']);
                unset($field['options']['attr']['class']);
            }

            $field['options'] = array_merge_recursive($field['options'], [
                'attr' => $attr,
            ]);
        }

        $type = FieldType::get($field);
        $options = FieldOptions::get($name, $field, $config);

        $formBuilder->add($name, $type, $options);
    }

    private function addHoneypot(string $formName, SymfonyFormBuilder $formBuilder, Collection $config): void
    {
        if ($config->get('honeypot', false)) {
            $honeypot = new Honeypot($formName, $formBuilder);
            $honeypot->addField();
        }
    }
}
