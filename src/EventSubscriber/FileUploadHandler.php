<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Bolt\BoltForms\FormHelper;
use Bolt\Common\Str;
use Cocur\Slugify\Slugify;
use Sirius\Upload\Handler;
use Sirius\Upload\Result\File;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tightenco\Collect\Support\Collection;
use Symfony\Component\Filesystem\Path;

class FileUploadHandler implements EventSubscriberInterface
{
    /** @var string */
    private $projectDir;

    /** @var FormHelper */
    private $helper;

    public function __construct(string $projectDir = '', FormHelper $helper)
    {
        $this->helper = $helper;
        $this->projectDir = $projectDir;
    }

    public function handleEvent(PostSubmitEvent $event): void
    {
        $form = $event->getForm();
        $formConfig = $event->getFormConfig();

        $fields = $form->all();
        foreach ($fields as $field) {
            $fieldConfig = $formConfig->get('fields')[$field->getName()] ?? null;
            if ($fieldConfig && $fieldConfig['type'] === 'file') {
                $this->processFileField($field, collect($fieldConfig), $event);
            }
        }
    }

    private function processFileField(Form $field, Collection $fieldConfig, PostSubmitEvent $event): void
    {
        $file = $field->getData();
        $form = $event->getForm();
        $formConfig = $event->getFormConfig();

        $filename = $this->getFilename($field->getName(), $form, $formConfig);
        $path = $fieldConfig['directory'] ?? '/uploads/';
        Str::ensureStartsWith($path, \DIRECTORY_SEPARATOR);
        $files = $this->uploadFiles($filename, $file, $path);

        if (isset($fieldConfig['attach']) && $fieldConfig['attach']) {
            $event->addAttachments([$field->getName() => $files]);
        }
    }

    private function getFilename(string $fieldname, Form $form, Collection $formConfig): string
    {
        $filenameFormat = $formConfig->get('fields')[$fieldname]['file_format'] ?? 'Uploaded file' . uniqid();
        $filename = $this->helper->get($filenameFormat, $form);

        if (! $filename) {
            $filename = uniqid();
        }

        return $filename;
    }

    /**
     * @param UploadedFile|array $file
     */
    private function uploadFiles(string $filename, $file, string $path = ''): array
    {
        $uploadPath = $this->projectDir . $path;
        $uploadHandler = new Handler($uploadPath, [
            Handler::OPTION_AUTOCONFIRM => true,
            Handler::OPTION_OVERWRITE => false,
        ]);

        $uploadHandler->setPrefix(mb_substr(md5((string) time()), 0, 8) . '_' . $filename);

        $uploadHandler->setSanitizerCallback(function ($name) {
            return $this->sanitiseFilename($name);
        });

        /** @var File $processed */
        $processed = $uploadHandler->process($file);

        $result = [];
        if ($processed->isValid()) {
            $processed->confirm();

            if (is_iterable($processed)) {
                foreach ($processed as $file) {
                    $result[] = $uploadPath . $file->__get('name');
                }
            } else {
                $result[] = $uploadPath . $processed->__get('name');
            }
        }

        // Very ugly. But it works when later someone uses Request::createFromGlobals();
        $_FILES = [];

        return $result;
    }

    private function sanitiseFilename(string $filename): string
    {
        $extensionSlug = new Slugify([
            'regexp' => '/([^a-z0-9]|-)+/',
        ]);
        $filenameSlug = new Slugify([
            'lowercase' => false,
        ]);

        $extension = $extensionSlug->slugify(Path::getExtension($filename));
        $filename = $filenameSlug->slugify(Path::getFilenameWithoutExtension($filename));

        return $filename . '.' . $extension;
    }

    public static function getSubscribedEvents()
    {
        return [
            'boltforms.post_submit' => ['handleEvent', 40],
        ];
    }
}
