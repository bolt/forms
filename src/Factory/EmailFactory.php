<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Bolt\Common\Str;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Address;
use Tightenco\Collect\Support\Collection;

class EmailFactory
{
    /** @var Form */
    private $form;

    /** @var Collection */
    private $config;

    /** @var Collection */
    private $notification;

    public function create(Collection $config, Form $form, array $meta = []): TemplatedEmail
    {
        $this->config = $config;
        $this->notification = collect($config->get('notification', []));
        $this->form = $form;

        $debug = (bool) $config->get('debug')['enabled'];

        $email = (new TemplatedEmail())
            ->from($this->getFrom())
            ->to($this->getTo())
            ->subject($this->getSubject())
            ->htmlTemplate($this->getEmailTemplate())
            ->context([
                'data' => $form->getData(),
                'formname' => $form->getName(),
                'meta' => $meta,
                'config' => $config,
            ]);

        if (self::hasCc()) {
            $email->cc($this->getCc());
        }

        if ($this->hasBcc()) {
            $email->bcc($this->getBcc());
        }

        if ($this->hasBcc()) {
            $email->bcc($this->getBcc());
        }

        if ($this->hasReplyTo()) {
            $email->replyTo($this->getReplyTo());
        }

        // Override the "to"
        if ($debug) {
            $email->to($this->config->get('debug')['address']);
        }

        return $email;
    }

    protected function getSubject(): string
    {
        $subject = $this->notification->get('subject', 'Untitled email');
        $subject = Str::ensureStartsWith($subject, $this->notification->get('subject_prefix', '[Boltforms] ') . ' ');

        return $this->parsePartial($subject);
    }

    protected function getFrom(): Address
    {
        return $this->getAddress('from_email', 'from_name');
    }

    protected function getTo(): Address
    {
        return $this->getAddress('to_email', 'to_name');
    }

    protected function hasCc(): bool
    {
        return $this->notification->has('cc_email');
    }

    protected function getCc(): Address
    {
        return $this->getAddress('cc_email', 'cc_name');
    }

    protected function hasBcc(): bool
    {
        return $this->notification->has('bcc_email');
    }

    protected function getBcc(): Address
    {
        return $this->getAddress('bcc_email', 'bcc_name');
    }

    protected function hasReplyTo(): bool
    {
        return $this->notification->has('replyto_email');
    }

    protected function getReplyTo(): Address
    {
        return $this->getAddress('replyto_email', 'replyto_name');
    }

    private function getAddress(string $email, string $name): Address
    {
        $email = $this->parsePartial($this->notification->get($email));
        $name = $this->parsePartial($this->notification->get($name));

        return new Address($email, $name);
    }

    protected function getEmailTemplate(): string
    {
        $templates = $this->config->get('templates', []);

        if (! in_array('email', $templates, true)) {
            return '@boltforms/email.html.twig';
        }

        return $templates['email'];
    }

    private function parsePartial(string $partial): string
    {
        $fields = $this->form->getData();

        return Str::placeholders($partial, $fields);
    }
}
