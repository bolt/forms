<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Configuration\Config;
use Bolt\Entity\Content;
use Bolt\Enum\Statuses;
use Bolt\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Tightenco\Collect\Support\Collection;

class ContentTypePersister implements EventSubscriberInterface
{
    /** @var Config */
    private $boltConfig;

    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(Config $boltConfig, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->boltConfig = $boltConfig;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    public function handleSaveToContenttype(PostSubmitEvent $event): void
    {
        $form = $event->getForm();

        // Don't save anything if the form isn't valid
        if (! $form->isValid()) {
            return;
        }

        $config = collect(collect($event->getFormConfig()->get('database', []))->get('contenttype', false));

        // If contenttype is not configured, bail out.
        if (! $config) {
            return;
        }

        if (! $this->boltConfig->getContentType($config->get('name', ''))) {
            return; // todo: handle this error message better
        }

        $content = new Content();
        $this->setContentData($content, $config);
        $this->setContentFields($content, $form, $event, $config);
        $this->saveContent($content);
    }

    private function setContentData(Content $content, Collection $config): void
    {
        $content->setStatus($config->get('status', Statuses::PUBLISHED));
        $contentType = $this->boltConfig->getContentType($config->get('name'));
        $content->setContentType($contentType->get('slug'));
        $content->setDefinition($contentType);

        if ($config->get('author', false)) {
            $user = $this->userRepository->findOneByUsername($config->get('author'));
            $content->setAuthor($user);
        }
    }

    private function setContentFields(Content $content, Form $form, PostSubmitEvent $event, Collection $config): void
    {
        $mapping = collect($config->get('field_map'));

        $data = array_merge(
            $event->getMeta(),
            $form->getData(),
        );

        foreach ($data as $field => $value) {
            $name = $mapping->get($field, $field);

            if ($name !== null) {
                $content->setFieldValue($name, $value);
            }
        }
    }

    private function saveContent(Content $content): void
    {
        $this->em->persist($content);
        $this->em->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => ['handleSaveToContenttype', 10],
        ];
    }
}
