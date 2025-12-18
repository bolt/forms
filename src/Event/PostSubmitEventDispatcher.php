<?php

namespace Bolt\BoltForms\Event;

use Bolt\BoltForms\BoltFormsConfig;
use Illuminate\Support\Collection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class PostSubmitEventDispatcher
{
    /** @var Collection */
    private $dispatchedForms;

    public function __construct(
        private readonly BoltFormsConfig $config,
        private readonly EventDispatcherInterface $dispatcher
    ) {
        $this->dispatchedForms = collect([]);
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
