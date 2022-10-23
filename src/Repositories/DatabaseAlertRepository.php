<?php

namespace Yousefpackage\JoeProxy\Repositories;

use Illuminate\Database\Query\Builder;
use Yousefpackage\JoeProxy\Repositories\Contracts\AlertRepository;

class DatabaseAlertRepository implements AlertRepository
{

    /**
     * The key we will use to search and save our logs.
     *
     * @var string
     */
    protected string $resourceKey = 'logs';

    /**
     * @var Builder
     */
    private Builder $query;

    /**
     * @var array
     */
    private array $supportedSearchCriteria = ['id', 'ip', 'os'];

    /**
     * @param Builder $query
     * @return void
     */
    public function setQuery(Builder $query)
    {
        $this->query = $query;
    }

    public function findBy(array $criteria = [])
    {
        $query = $this->query->where('key', '=', $this->resourceKey);
        $criteria = $this->cleanCriteria($criteria);

        foreach ($criteria as $key => $criterion) {
            if (is_array($criterion)) {
                $query->whereIn($key, $criterion);
                continue;
            }
        }
    }

    protected function cleanCriteria(array $criteria): array
    {
        $cleaned = [];
        foreach ($criteria as $key => $value) {
            if (key_exists($key, $this->supportedSearchCriteria) && $value) {
                $cleaned[$key] = $value;
            }
        }

        return $cleaned;
    }
}