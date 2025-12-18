<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Log\LoggerTrait;
use Illuminate\Support\Collection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        // We cannot serialize Uploaded file. See https://github.com/symfony/symfony/issues/19572.
        // So instead, let's get the filename. ¯\_(ツ)_/¯
        // todo: Can we fix this?
        foreach ($data as $key => $value) {
            if ($value instanceof UploadedFile) {
                $data[$key] = $value->getClientOriginalName();
            } elseif (is_iterable($value)) {
                // Multiple files
                foreach ($value as $k => $v) {
                    if ($v instanceof UploadedFile) {
                        $data[$key][$k] = $v->getClientOriginalName();
                    }
                }
            }
        }

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
