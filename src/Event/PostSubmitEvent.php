<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Event;

use Bolt\BoltForms\BoltFormsConfig;
use Bolt\BoltForms\Extension;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class PostSubmitEvent extends Event
{
    public const NAME = 'boltforms.post_submit';

    private bool $spam = false;
    private Collection $attachments;

    public function __construct(
        private readonly FormInterface $form,
        private readonly BoltFormsConfig $config,
        private readonly string $formName,
        private readonly Request $request
    ) {
        $this->attachments = collect();
    }

    public function getFormName(): string
    {
        return $this->formName;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }

    public function getExtension(): ?Extension
    {
        return $this->config->getExtension();
    }

    public function getConfig(): Collection
    {
        return $this->config->getConfig();
    }

    public function getFormConfig(): Collection
    {
        return new Collection($this->getConfig()->get($this->formName));
    }

    public function getMeta(): array
    {
        return [
            'ip' => $this->request->getClientIp(),
            'timestamp' => Carbon::now(),
            'path' => $this->request->getRequestUri(),
            'url' => $this->request->getUri(),
            'attachments' => $this->getAttachments(),
        ];
    }

    public function markAsSpam(bool $spam): void
    {
        $this->spam = $spam;
    }

    public function isSpam(): bool
    {
        return $this->spam;
    }

    public function addAttachments(array $attachments): void
    {
        $this->attachments = $this->attachments->merge($attachments);
    }

    public function getAttachments(): array
    {
        return $this->attachments->toArray();
    }
}
