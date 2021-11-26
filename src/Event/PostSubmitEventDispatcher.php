<?php

namespace Bolt\BoltForms\Event;

use Bolt\BoltForms\BoltFormsConfig;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Tightenco\Collect\Support\Collection;

class PostSubmitEventDispatcher
{
    /** @var BoltFormsConfig */
    private $config;

    /** @var Collection */
    private $dispatchedForms;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(BoltFormsConfig $config, EventDispatcherInterface $dispatcher)
    {
        $this->config = $config;
        $this->dispatchedForms = collect([]);
        $this->dispatcher = $dispatcher;
    }

    public function handle(string $formName, Form $form, Request $request): void
    {
        if (! $this->shouldDispatch($formName)) {
            return;
        }

        $this->dispatch($formName, $form, $request);
    }

    private function shouldDispatch(string $formName): bool
    {
        return ! $this->dispatchedForms->contains($formName);
    }

    private function dispatch(string $formName, Form $form, Request $request): void
    {
        $event = new PostSubmitEvent($form, $this->config, $formName, $request);
        $this->dispatcher->dispatch($event, PostSubmitEvent::NAME);
        $this->config->getExtension()->dump(sprintf('Form "%s" has been submitted', $formName));

        $this->dispatchedForms->add($formName);
    }
}
