<?php

namespace Yousefpackage\JoeProxy\Repositories;

use RuntimeException;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use SY\DataObject\Contracts\DataObject;
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

    public function get(int $id): DataObject
    {
        if(!$model = $this->getQuery()->find($id)) {
            throw new RuntimeException("No models found with this id #$id");
        }

        return $this->make($model);
    }

    /**
     * @param DataObject $object
     * @return bool
     */
    public function save(DataObject $object): bool
    {
        $data = $object->toArray();
        if ($object->getId()) {
            if (isset($data['id'])) {
                unset($data['id']);
            }

            return $this->getQuery()
                ->where('id', '=', $object->getId())
                ->update($data);
        }

        return $this->getQuery()
            ->insert($data);
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
     * @param array $items
     * @return Collection<DataObject>
     */
    protected function toCollection(array $items): Collection
    {
        $models = [];
        foreach ($items as $item) {
            $models[] = $this->make($item);
        }

        return new Collection($models);
    }

    /**
     * @return Builder
     */
    abstract protected function getQuery(): Builder;

    /**
     * @return array
     */
    abstract protected function supportedSearchCriteria(): array;

    /**
     * @param array|object $data
     * @return DataObject
     */
    abstract protected function make($data): DataObject;
}