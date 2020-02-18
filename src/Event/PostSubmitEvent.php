<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Event;

use Carbon\Carbon;
use Symfony\Component\Form\Form;
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

    private $formName;

    public function __construct(Form $form, Collection $config, string $formName, Request $request)
    {
        $this->form = $form;
        $this->config = $config;
        $this->formName = $formName;
        $this->request = $request;
    }

    public function getFormName(): string
    {
        return $this->formName;
    }

    public function getForm(): Form
    {
        return $this->form;
    }

    public function getConfig(): Collection
    {
        return $this->config;
    }

    public function getFormConfig(): Collection
    {
        return new Collection($this->config->get($this->formName));
    }

    public function getMeta()
    {
        return [
            'ip' => $this->request->getClientIp(),
            'timestamp' => Carbon::now(),
            'path' => $this->request->getRequestUri(),
            'url' => $this->request->getUri(),
        ];
    }
}
