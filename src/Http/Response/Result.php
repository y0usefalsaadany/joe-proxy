<?php

namespace Yousefpackage\JoeProxy\Http\Response;

use Iterator;
use Traversable;
use ArrayIterator;
use RuntimeException;
use Illuminate\Contracts\Pagination\Paginator;
use Yousefpackage\JoeProxy\Http\Response\Contracts\PaginatableResult;

class Result implements PaginatableResult
{

    /**
     * @var callable
     */
    private $getter;

    /**
     * @var callable
     */
    private $paginatorCreator;

    public function __construct(callable $getter, callable $paginatorCreator)
    {

        $this->getter = $getter;
        $this->paginatorCreator = $paginatorCreator;
    }

    /**
     * @return array|ArrayIterator|Iterator|Traversable
     */
    public function getIterator()
    {
        $getter = $this->getter;
        $result = $getter();

        if (!$result) {
            return new ArrayIterator([]);
        }

        if ($result instanceof Iterator) {
            return $result;
        }

        if (is_array($result)) {
            return new ArrayIterator($result);
        }

        if (!$result instanceof Traversable) {
            throw new RuntimeException('The returned result of the assigned callable is not supported (traversable)');
        }

        $array = [];

        foreach ($result as $item) {
            $array[] = $item;
        }

        return new ArrayIterator($array);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return Paginator
     */
    public function paginate(int $page = 1, int $perPage = 15): Paginator
    {
        $paginatorCreator = $this->paginatorCreator;

        return $paginatorCreator($page, $perPage);
    }
}