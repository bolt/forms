<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\BoltForms\Event\PostSubmitEventDispatcher;
use Bolt\Twig\Notifications;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class FormRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private Notifications $notifications,
        private Environment $twig,
        private FormBuilder $builder,
        private RequestStack $requestStack,
        private EventDispatcherInterface $dispatcher,
        private BoltFormsConfig $config,
        private PostSubmitEventDispatcher $postSubmitEventDispatcher
    ) {
    }

    public function run(string $formName = '', array $data = [], bool $warn = true)
    {
        $config = $this->config->getConfig();
        $extension = $this->config->getExtension();

        if (! $config->has($formName)) {
            return $warn ? $this->notifications->warning(
                '[Boltforms] Incorrect usage of form',
                'The form "' . $formName . '" is not defined. '
            ) : '';
        }

        $formConfig = collect($config->get($formName));
        $form = $this->builder->build($formName, $data, $config, $this->dispatcher);

        $request = $this->requestStack->getCurrentRequest();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->postSubmitEventDispatcher->handle($formName, $form, $request);
        }

        $extension->dump($formConfig);
        $extension->dump($form);

        if ($config->get('honeypot')) {
            $honeypot = new Honeypot($formName);
            $honeypotName = $honeypot->generateFieldName(true);
        } else {
            $honeypotName = false;
        }

        if ($formConfig->has('templates') && isset($formConfig->get('templates')['form'])) {
            $template = $formConfig->get('templates')['form'];
        } else {
            $template = $config->get('templates')['form'];
        }

        return $this->twig->render($template, [
            'boltforms_config' => $config,
            'form_config' => $formConfig,
            'debug' => $config->get('debug'),
            'honeypot_name' => $honeypotName,
            'form' => $form->createView(),
            'submitted' => $form->isSubmitted(),
            'valid' => $form->isSubmitted() && $form->isValid(),
            'data' => $form->getData(),
            // Deprecated
            'formconfig' => $formConfig,
            // Deprecated
            'honeypotname' => $honeypotName,
        ]);
    }
}
