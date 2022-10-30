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
     * @param array $data
     * @return DataObject
     */
    public function make(array $data): DataObject;

    /**
     * @param DataObject $object
     * @return bool
     */
    public function save(DataObject $object): bool;
}