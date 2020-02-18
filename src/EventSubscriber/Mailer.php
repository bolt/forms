<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Log\LoggerTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer implements EventSubscriberInterface
{
    use LoggerTrait;

    /** @var PostSubmitEvent */
    private $event;

    /** @var MailerInterface */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handleEvent(PostSubmitEvent $event): void
    {
        $this->event = $event;
        dump('joe');
        dump($event->getForm());
        dump($event->getFormName());
        dump($event->getFormConfig());
        $this->mail();
        die();
    }

    public function mail()
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
        $sentEmail = $this->mailer->send($email);

        dump($sentEmail->getMessageId());
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => 'handleEvent',
        ];
    }
}

