<?php

declare(strict_types=1);

namespace Bolt\BoltForms\Event;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

/**
 * External event interface for BoltForms
 *
 * Copyright (c) 2014-2016 Gawain Lynch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License or GNU Lesser
 * General Public License as published by the Free Software Foundation,
 * either version 3 of the Licenses, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Gawain Lynch <gawain.lynch@gmail.com>
 * @copyright Copyright (c) 2014-2016, Gawain Lynch
 * @license http://opensource.org/licenses/GPL-3.0 GNU Public License 3.0
 * @license http://opensource.org/licenses/LGPL-3.0 GNU Lesser General Public License 3.0
 */
class BoltFormsEvent extends FormEvent
{
    /** @var \Symfony\Component\Form\FormEvent */
    protected $event;
    /** @var array */
    protected $data = [];
    /** @var \Symfony\Component\Form\FormInterface */
    protected $form;
    /** @var string */
    protected $formsEventName;

    public function __construct(FormEvent $event, string $formsEventName)
    {
        parent::__construct($event->getForm(), $event->getData());

        $this->event = $event;
        $this->formsEventName = $formsEventName;
    }

    public function getEvent(): FormEvent
    {
        return $this->event;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData($data): void
    {
        if (in_array($this->formsEventName, [FormEvents::PRE_SUBMIT, BoltFormsEvents::PRE_SUBMIT], true)) {
            $this->event->setData($data);
        } else {
            throw new \RuntimeException(self::class . '::' . __FUNCTION__ . ' can only be called in BoltFormsEvents::PRE_SUBMIT or FormEvents::PRE_SUBMIT');
        }
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
