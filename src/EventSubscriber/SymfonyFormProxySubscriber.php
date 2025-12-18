<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\BoltFormsEvent;
use Bolt\BoltForms\Event\BoltFormsEvents;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Dedicated subscriber interface for BoltForms
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
class SymfonyFormProxySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EventDispatcherInterface $boltFormsDispatcher
    ) {
    }

    /**
     * Events that BoltFormsSubscriber subscribes to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::POST_SET_DATA => 'postSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
            FormEvents::SUBMIT => 'submit',
        ];
    }

    /**
     * Event triggered on FormEvents::PRE_SET_DATA
     */
    public function preSetData(FormEvent $event, string $eventName, EventDispatcher $dispatcher): void
    {
        $this->dispatch(BoltFormsEvents::PRE_SET_DATA, $event, $eventName, $dispatcher);
    }

    /**
     * Event triggered on FormEvents::POST_SET_DATA
     */
    public function postSetData(FormEvent $event, string $eventName, EventDispatcher $dispatcher): void
    {
        $this->dispatch(BoltFormsEvents::POST_SET_DATA, $event, $eventName, $dispatcher);
    }

    /**
     * Form pre submission event
     *
     * Event triggered on FormEvents::PRE_SUBMIT
     *
     * To modify data on the fly, this is the point to do it using:
     *  $data = $event->getData();
     *  $event->setData($data);
     */
    public function preSubmit(FormEvent $event, string $eventName, EventDispatcher $dispatcher): void
    {
        $this->dispatch(BoltFormsEvents::PRE_SUBMIT, $event, $eventName, $dispatcher);
    }

    /**
     * Event triggered on FormEvents::SUBMIT
     */
    public function submit(FormEvent $event, string $eventName, EventDispatcher $dispatcher): void
    {
        $this->dispatch(BoltFormsEvents::SUBMIT, $event, $eventName, $dispatcher);
    }

    /**
     * Dispatch event.
     */
    protected function dispatch(string $eventName, FormEvent $event, string $formsEventName, EventDispatcher $dispatcher): void
    {
        $event = new BoltFormsEvent($event, $eventName);
        $this->boltFormsDispatcher->dispatch($event, $eventName);
    }
}
