<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Common\Str;
use Bolt\Log\LoggerTrait;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Tightenco\Collect\Support\Collection;

class Mailer implements EventSubscriberInterface
{
    use LoggerTrait;

    /** @var PostSubmitEvent */
    private $event;

    /** @var MailerInterface */
    private $mailer;

    /** @var Collection */
    private $notification;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handleEvent(PostSubmitEvent $event): void
    {
        $this->event = $event;
        $this->notification = new Collection($this->event->getFormConfig()->get('notification'));

        $this->mail();
    }

    public function mail()
    {
        dump($this->event->getMeta());

        if (!$this->notification->get('enabled') && !$this->notification->get('email')) {
            return;
        }

        $email = (new TemplatedEmail())
            ->from($this->getFrom())
            ->to($this->getTo())
            ->subject($this->getSubject())
            ->htmlTemplate($this->event->getConfig()->get('templates')['email'])
            ->context([
                'data' => $this->event->getForm()->getData(),
                'formname' => $this->event->getFormName(),
                'meta' => $this->event->getMeta(),
                'config' => $this->event->getFormConfig()
            ]);

        if ($this->hasCc()) {
            $email->cc($this->getCc());
        }

        if ($this->hasBcc()) {
            $email->bcc($this->getBcc());
        }

        if ($this->hasBcc()) {
            $email->bcc($this->getBcc());
        }

        if ($this->getReplyTo()) {
            $email->replyTo($this->getReplyTo());
        }

        $sentEmail = $this->mailer->send($email);

        $this->logger->info('[Boltforms] Form {formname} sent email to {recipient}',
            ['formname' => $this->event->getFormName(), 'recipient' => $this->getTo()->toString()]
        );
    }

    private function getSubject(): string
    {
        $subject = $this->notification->get('subject', 'Untitled email');
        $subject = Str::ensureStartsWith($subject, '[Boltforms] ');

        return $this->parsePartial($subject);
    }

    private function getFrom(): Address
    {
        return $this->getAddress('from_email', 'from_name');
    }

    private function getTo(): Address
    {
        return $this->getAddress('to_email', 'to_name');
    }

    private function hasCc(): bool
    {
        return $this->notification->has('cc_email');
    }

    private function getCc(): Address
    {
        return $this->getAddress('cc_email', 'cc_name');
    }

    private function hasBcc(): bool
    {
        return $this->notification->has('bcc_email');
    }

    private function getBcc(): Address
    {
        return $this->getAddress('bcc_email', 'bcc_name');
    }


    private function hasReplyTo(): bool
    {
        return $this->notification->has('replyto_email');
    }

    private function getReplyTo(): Address
    {
        return $this->getAddress('replyto_email', 'replyto_name');
    }

    private function getAddress(string $email, string $name): Address
    {
        $email = $this->parsePartial($this->notification->get($email));
        $name = $this->parsePartial($this->notification->get($name));

        return new Address($email, $name);
    }

    private function parsePartial(string $partial): string
    {
        $fields = $this->event->getForm()->getData();

        return Str::placeholders($partial, $fields);
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => 'handleEvent',
        ];
    }
}

