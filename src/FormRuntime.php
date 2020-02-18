<?php

declare(strict_types=1);

namespace Bolt\BoltForms;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Extension\ExtensionRegistry;
use Bolt\Twig\Notifications;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Tightenco\Collect\Support\Collection;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

class FormRuntime implements RuntimeExtensionInterface
{
    /** @var ExtensionRegistry */
    private $registry;

    /** @var Notifications */
    private $notifications;

    /** @var FormBuilder */
    private $builder;

    /** @var Environment */
    private $twig;

    /** @var Request */
    private $request;

    /** @var EventDispatcher */
    private $dispatcher;

    public function __construct(
        ExtensionRegistry $extensionRegistry,
        Notifications $notifications,
        Environment $twig,
        FormBuilder $builder,
        RequestStack $requestStack,
        EventDispatcherInterface $dispatcher
    ) {
        $this->registry = $extensionRegistry;
        $this->notifications = $notifications;
        $this->twig = $twig;
        $this->builder = $builder;
        $this->request = $requestStack->getCurrentRequest();
        $this->dispatcher = $dispatcher;
    }

    private function getConfig(): Collection
    {
        $extension = $this->registry->getExtension('Bolt\\BoltForms');

        return $extension->getConfig();
    }

    public function run(string $formName = '')
    {
        $config = $this->getConfig();

        if (! $config->has($formName)) {
            return $this->notifications->warning(
                '[Boltforms] Incorrect usage of form',
                'The form "' . $formName . '" is not defined. '
            );
        }

        $formConfig = $config->get($formName);
        $form = $this->builder->build($formName, $formConfig);
        $form->handleRequest($this->request);

        if ($form->isSubmitted()) {
            $event = new PostSubmitEvent($form, $config, $formName, $this->request);
            $this->dispatcher->dispatch($event, PostSubmitEvent::NAME);
            dump(sprintf('Form "%s" has been submitted', $formName));
        }

        dump($formConfig);
        dump($form);

        return $this->twig->render('@boltforms/form.html.twig', [
            'formconfig' => $formConfig,
            'debug' => $config->get('debug'),
            'form' => $form->createView(),
            'submitted' => $form->isSubmitted(),
            'valid' => $form->isSubmitted() && $form->isValid(),
            'data' => $form->getData(),
        ]);
    }
}
