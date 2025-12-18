<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Illuminate\Support\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;

abstract class AbstractPersistSubscriber implements EventSubscriberInterface
{
    public function handleSave(PostSubmitEvent $event): void
    {
        $form = $event->getForm();

        // Don't save anything if the form isn't valid
        if (! $form->isValid()) {
            return;
        }

        $config = collect($event->getFormConfig()->get('database', false));

        // If contenttype is not configured, bail out.
        if (! $config) {
            return;
        }

        $this->save($event, $form, $config);
    }

    abstract public function save(PostSubmitEvent $event, Form $form, Collection $config): void;

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => ['handleSave', 10],
        ];
    }
}
