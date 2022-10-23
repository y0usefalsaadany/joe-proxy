<?php

namespace Yousefpackage\JoeProxy\Repositories;

use Illuminate\Database\Query\Builder;
use Yousefpackage\JoeProxy\Repositories\Contracts\LogRepository;

class DatabaseLogRepository implements LogRepository
{
    private Builder $query;


    /**
     * @param Builder $query
     * @return void
     */
    public function setQuery(Builder $query)
    {
        $this->query = $query;
    }
}