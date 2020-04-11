<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Log\LoggerTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tightenco\Collect\Support\Collection;

class Logger implements EventSubscriberInterface
{
    use LoggerTrait;

    /** @var PostSubmitEvent */
    private $event;

    /** @var Collection */
    private $notification;

    public function __construct()
    {
    }

    public function handleEvent(PostSubmitEvent $event): void
    {
        $this->event = $event;
        $this->notification = new Collection($this->event->getFormConfig()->get('notification'));

        if (! $this->notification->get('log')) {
            $this->log();
        }
    }

    public function log(): void
    {
        // Don't log anything, if the form isn't valid
        if (! $this->event->getForm()->isValid()) {
            return;
        }

        $data = $this->event->getForm()->getData();

        $data['formname'] = $this->event->getFormName();

        $this->logger->info('[Boltforms] Form {formname} - submitted Form data (see \'Context\')', $data);

        $this->event->getExtension()->dump('Submitted form data was logged in the System log.');
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => ['handleEvent', 10],
        ];
    }
}
