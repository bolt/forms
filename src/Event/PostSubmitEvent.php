<?php


namespace Bolt\BoltForms\Event;

use Symfony\Component\Form\Form;
use Symfony\Contracts\EventDispatcher\Event;
use Tightenco\Collect\Support\Collection;

class PostSubmitEvent extends Event
{
    public const NAME = 'boltforms.post_submit';

    /** @var Form */
    private $form;

    /** @var Collection */
    private $config;

    private $formname;

    public function __construct(Form $form, Collection $config, string $formName)
    {
        $this->form = $form;
        $this->config = $config;
        $this->formName = $formName;
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

}