<?php

namespace Yousefpackage\JoeProxy\Http\Response\Contracts;

use Illuminate\Contracts\Pagination\Paginator;
use IteratorAggregate;

interface PaginatableResult extends IteratorAggregate
{
    /**
     * @param int $page
     * @param int $perPage
     * @return Paginator
     */
    public function paginate(int $page = 1, int $perPage = 15): Paginator;
}