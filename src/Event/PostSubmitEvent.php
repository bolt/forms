<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Event;

use Bolt\BoltForms\BoltFormsConfig;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class PostSubmitEvent extends Event
{
    public const NAME = 'boltforms.post_submit';

    /** @var bool */
    private $spam = false;

    /** @var Collection */
    private $attachments;

    public function __construct(
        private Form $form,
        private BoltFormsConfig $config,
        private string $formName,
        private Request $request
    ) {
        $this->attachments = collect([]);
    }

    public function getFormName(): string
    {
        return $this->formName;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function getExtension()
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

    public function markAsSpam($spam): void
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
