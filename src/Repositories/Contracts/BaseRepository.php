<?php

namespace Yousefpackage\JoeProxy\Repositories\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use SY\DataObject\Contracts\DataObject;
use Yousefpackage\JoeProxy\Http\Response\Contracts\PaginatableResult;

interface BaseRepository
{
    /**
     * @param array $criteria
     * @return iterable<DataObject>|Paginator|PaginatableResult
     */
    public function findBy(array $criteria);

    /**
     * @param int $id
     * @return DataObject
     */
    public function get(int $id): DataObject;

    /**
     * @param DataObject $model
     * @return bool
     */
    public function save(DataObject $model): bool;
}