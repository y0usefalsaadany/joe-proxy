<?php

namespace Yousefpackage\JoeProxy\Repositories;

use Illuminate\Database\Query\Builder;
use Yousefpackage\JoeProxy\Http\Response\Result;

abstract class AbstractBaseRepository
{
    /**
     * @param array $criteria
     * @return Result
     */
    public function findBy(array $criteria): Result
    {
        $query = $this->getQuery();
        $criteria = $this->cleanCriteria($criteria);

        foreach ($criteria as $key => $criterion) {
            if (is_array($criterion)) {
                $query->whereIn($key, $criterion);
                continue;
            }

            $query->where($key, '=', $criterion);
        }

        return new Result(function () use ($query) {
            return $query->get();
        }, function (int $page = 1, int $perPage = 15) use ($query) {
            return $query->paginate([$perPage, '*', 'page', $page]);
        });
    }

    /**
     * @param array $criteria
     * @return array
     */
    protected function cleanCriteria(array $criteria): array
    {
        $cleaned = [];
        foreach ($criteria as $key => $value) {
            if (key_exists($key, $this->supportedSearchCriteria()) && $value) {
                $cleaned[$key] = $value;
            }
        }

        return $cleaned;
    }

    /**
     * @return Builder
     */
    abstract protected function getQuery(): Builder;

    /**
     * @return array
     */
    abstract protected function supportedSearchCriteria(): array;
}