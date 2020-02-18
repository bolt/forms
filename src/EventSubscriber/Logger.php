<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Common\Str;
use Bolt\Log\LoggerTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
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

        $this->log();
    }

    public function log()
    {
        if (!$this->notification->get('log')) {
            return;
        }

        $data = $this->event->getForm()->getData();

        $data['formname'] = $this->event->getFormName();

        $this->logger->info('[Boltforms] Form {formname} - submitted Form data (see \'Context\')', $data);

        dump('Submitted form data was logged in the System log.');
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => ['handleEvent', 100],
        ];
    }
}

