<?php

namespace Yousefpackage\JoeProxy\Repositories;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Builder;
use SY\DataObject\Contracts\DataObject;
use Yousefpackage\JoeProxy\Repositories\Contracts\LogRepository;

class DatabaseLogRepository implements LogRepository
{
    private Builder $query;

    /**
     * Table name
     *
     * @var string
     */
    protected string $table = 'logs';

    public function __construct(ConnectionResolverInterface $connectionResolver)
    {
        $this->query = $connectionResolver->connection()
            ->table($this->table)
            ->newQuery();
    }

    public function findBy(array $criteria)
    {

    }

    public function get(int $id): DataObject
    {

    }

    public function make(array $data): DataObject
    {

    }

    public function save(DataObject $object): bool
    {

    }
}