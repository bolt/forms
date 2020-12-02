<?php

declare(strict_types=1);

namespace Bolt\BoltForms\EventSubscriber;

use Bolt\BoltForms\Event\PostSubmitEvent;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use Tightenco\Collect\Support\Collection;

class DbTablePersister extends AbstractPersistSubscriber implements EventSubscriberInterface
{
    /** @var QueryBuilder */
    private $query;

    /** @var Logger */
    private $log;

    public function __construct(Connection $connection, LoggerInterface $log)
    {
        $this->query = $connection->createQueryBuilder();
        $this->log = $log;
    }

    public function save(PostSubmitEvent $event, Form $form, Collection $config): void
    {
        $config = collect($config->get('table', []));

        if (! $config) {
            return;
        }

        if (! $config->get('name', '')) {
            // todo: handle this error message better
            return;
        }

        $table = $config->get('name', '');
        $fields = $this->parseForm($form, $event, $config);
        $this->saveToTable($table, $fields);
    }

    private function parseForm(Form $form, PostSubmitEvent $event, Collection $config): array
    {
        $mapping = collect($config->get('field_map'));

        $data = array_merge(
            $event->getMeta(),
            $form->getData()
        );

        foreach (array_keys($data) as $field) {
            $name = $mapping->get($field, $field);

            if ($name === null) {
                unset($data[$field]);
            }
        }

        return $data;
    }

    private function saveToTable(string $table, array $fields): void
    {
        $columns = [];

        foreach (array_keys($fields) as $name) {
            $columns[$name] = '?';
        }

        $parameters = array_values($fields);

        $this->query
            ->insert($table)
            ->values($columns)
            ->setParameters($parameters);

        try {
            $this->query->execute();
        } catch (\Throwable $exception) {
            $this->log->error($exception->getMessage());
        }
    }
}
