<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\BoltForms\Factory\EmailFactory;
use Bolt\Common\Str;
use Bolt\Log\LoggerTrait;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
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

        // Don't send mails, if the form isn't valid
        if (! $this->event->getForm()->isValid()) {
            return;
        }

        if ($this->notification->get('enabled') || $this->notification->get('email')) {
            $this->mail();
        }
    }

    public function mail(): void
    {
        $email = $this->buildEmail();
        // @todo Returns `null`, whilst it _should_ return some info on whether it was successful.
        $this->mailer->send($email);

        $this->logger->info(
            '[Boltforms] Form {formname} sent email to {recipient}',
            [
                'formname' => $this->event->getFormName(),
                // is this casting right?
                'recipient' => (string) $email->getTo()[0]->getName(),
            ]
        );
    }

    public function buildEmail(): TemplatedEmail
    {
        $meta = $this->event->getMeta();

        $email = (new EmailFactory())->create($this->event->getFormConfig(), $this->event->getConfig(), $this->event->getForm(), $meta);

        if ($this->event->isSpam()) {
            $subject = Str::ensureStartsWith($email->getSubject(), '[SPAM] ');
            $email->subject($subject);
        }

        return $email;
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => ['handleEvent', 40],
        ];
    }
}
