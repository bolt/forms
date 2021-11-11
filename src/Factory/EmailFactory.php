<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Factory;

use Bolt\Common\Str;
use File;
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

    /** @var Collection */
    private $formConfig;

    /**
     * @param Collection $formConfig The config specific for the current form
     * @param Collection $config The global config defined config/extensions/bolt-boltforms.yaml
     * @param Form $form The form object
     * @param array $meta Metadata of the PostSubmitEvent
     */
    public function create(Collection $formConfig, Collection $config, Form $form, array $meta = []): TemplatedEmail
    {
        $this->config = $config;
        $this->notification = collect($formConfig->get('notification', []));
        $this->form = $form;
        $this->formConfig = $formConfig;

        $debug = (bool) $this->config->get('debug')['enabled'];

        $attachments = $meta['attachments'] ?? [];
        unset($meta['attachments']);

        $email = (new TemplatedEmail())
            ->from($this->getFrom())
            ->to($this->getTo())
            ->subject($this->getSubject())
            ->htmlTemplate($this->getEmailTemplate())
            ->context([
                'data' => $form->getData(),
                'formname' => $form->getName(),
                'meta' => $meta,
                'config' => $formConfig,
            ]);

        if (self::hasCc()) {
            $email->cc($this->getCc());
        }

        if ($this->hasBcc()) {
            $email->bcc($this->getBcc());
        }

        if ($this->hasReplyTo()) {
            $email->replyTo($this->getReplyTo());
        }

        foreach ($attachments as $name => $attachment) {
            /** @var File $attachment */
            foreach ($attachment as $file) {
                $email->attachFromPath($file, $name . '.' . pathinfo($file, PATHINFO_EXTENSION));
            }
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

        if (! \array_key_exists('email', $templates)) {
            return '@boltforms/email.html.twig';
        }

        if ($this->formConfig->has('templates') && isset($this->formConfig->get('templates')['email'])) {
            $template = $this->formConfig->get('templates')['email'];
        } else {
            $template = $templates['email'];
        }

        return $template;
    }

    private function parsePartial(string $partial): string
    {
        $fields = $this->form->getData();

        return Str::placeholders($partial, $fields);
    }
}
