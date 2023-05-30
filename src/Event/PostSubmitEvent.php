<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Event;

use Bolt\BoltForms\BoltFormsConfig;
use Carbon\Carbon;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;
use Tightenco\Collect\Support\Collection;

class PostSubmitEvent extends Event
{
    public const NAME = 'boltforms.post_submit';

    /** @var Form */
    private $form;

    /** @var Collection */
    private $config;

    /** @var string */
    private $formName;

    /** @var bool */
    private $spam = false;

    /** @var Request */
    private $request;

    /** @var Collection */
    private $attachments;

    public function __construct(Form $form, BoltFormsConfig $config, string $formName, Request $request)
    {
        $this->form = $form;
        $this->config = $config;
        $this->formName = $formName;
        $this->request = $request;
        $this->attachments = collect([]);

        $formConfig = $config->getConfig()->get($formName);
        if ($formConfig["attach"] ?? false) {
            foreach ($formConfig["fields"] as $field => $fieldConfig) {
                if ($fieldConfig["type"] !== "file") {
                    continue;
                }

                $files = $form->get($field)->getData();
                if (!is_iterable($files)) {
                    $files = [$files];
                }
                foreach ($files as $file) {
                    if (!$file instanceof UploadedFile || $file->getError()) {
                        continue;
                    }

                    $item = [
                        "content" => $file->getContent(),
                        "filename" => $file->getClientOriginalName(),
                        "mimetype" => $file->getMimeType(),
                    ];
                    $this->attachments->add(
                        $item
                    );
                }
            }
        }
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
