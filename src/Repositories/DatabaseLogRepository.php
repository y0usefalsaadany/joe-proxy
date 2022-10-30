<?php

namespace Yousefpackage\JoeProxy\Repositories;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Builder;
use SY\DataObject\Contracts\DataObject;
use Yousefpackage\JoeProxy\Models\Log;
use Yousefpackage\JoeProxy\Repositories\Contracts\LogRepository;

class DatabaseLogRepository extends AbstractBaseRepository implements LogRepository
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

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return $this->query;
    }

    /**
     * @return string[]
     */
    protected function supportedSearchCriteria(): array
    {
       return ['id', 'ip', 'os'];
    }

    /**
     * @param $data
     * @return DataObject
     */
    protected function make($data): DataObject
    {
        if (!is_array($data)) {
            $data = (array)$data;
        }

        return new Log($data);
    }
}