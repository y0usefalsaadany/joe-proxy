<?php

namespace Yousefpackage\JoeProxy\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\ConnectionResolverInterface;
use SY\DataObject\Contracts\DataObject;
use Yousefpackage\JoeProxy\Models\Alert;
use Yousefpackage\JoeProxy\Repositories\Contracts\AlertRepository;

class DatabaseAlertRepository extends AbstractBaseRepository implements AlertRepository
{

    /**
     * Table name
     *
     * @var string
     */
    protected string $table = 'alerts';

    /**
     * @var Builder
     */
    private Builder $query;

    /**
     * @param ConnectionResolverInterface $connectionResolver
     */
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
        return ['id', 'ip'];
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

        return new Alert($data);
    }
}