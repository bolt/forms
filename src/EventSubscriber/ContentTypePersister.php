<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\Configuration\Config;
use Bolt\Entity\Content;
use Bolt\Enum\Statuses;
use Bolt\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Tightenco\Collect\Support\Collection;

class ContentTypePersister extends AbstractPersistSubscriber implements EventSubscriberInterface
{
    /** @var Config */
    private $boltConfig;

    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string */
    private $projectDir;

    public function __construct(Config $boltConfig, UserRepository $userRepository, EntityManagerInterface $em, string $projectDir = '')
    {
        $this->boltConfig = $boltConfig;
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->projectDir = $projectDir;
    }

    public function save(PostSubmitEvent $event, Form $form, Collection $config): void
    {
        $config = collect($config->get('contenttype', []));

        if (! $config) {
            return;
        }

        if (! $this->boltConfig->getContentType($config->get('name', ''))) {
            // todo: handle this error message better
            return;
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
            $form->getData()
        );

        // Map given data to fields, using the mapping
        foreach ($data as $field => $value) {
            $name = $mapping->get($field, $field);

            if ($name === null) {
                continue;
            }

            if (is_array($value)) {
                $value = implode(', ', array_map(function ($entry) {
                    // check if $entry is an array and not empty
                    return (is_array($entry) && count($entry) > 0) ? $entry[0] : '';
                }, $value));
            }
            
            if ($value instanceof \DateTimeInterface) {
                $value = Carbon::instance($value);
            }
            
            $value = (string) $value;

            if (in_array($name, array_keys($data['attachments'] ?? null), true)) {
                // Don't save the file. Rather, save the filename that's in attachments.
                $value = $data['attachments'][$name];

                // Don't save the full path. Only the path without the project dir.
                $newValue = [];
                foreach ($value as $path) {
                    $newValue[] = str_replace($this->projectDir, '', $path);
                }

                $value = $newValue;
            }

            // We forcibly set it, if the field is defined OR (`ignore_missing` is set AND it is `false`)
            if ($content->hasFieldDefined($name) || (isset($config['ignore_missing']) && ! $config['ignore_missing'])) {
                $content->setFieldValue($name, $value);
            }
        }

        // And the reverse: Map the mapping to fields from the data
        foreach ($mapping as $mappingName => $fieldName) {
            if ($content->hasFieldDefined($mappingName) && array_key_exists($fieldName, $data)) {
                $content->setFieldValue($mappingName, $data[$fieldName]);
            }
        }
    }

    private function saveContent(Content $content): void
    {
        $this->em->persist($content);
        $this->em->flush();
    }
}
