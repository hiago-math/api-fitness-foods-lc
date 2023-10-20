<?php

namespace Infrastructure\Repositories;

use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    private $model;

    public function __construct(string  $model)
    {
        $this->model = instantiate_class($model);
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param array $values
     * @return Collection
     */
    protected function toCollect(array $values): Collection
    {
        return collect($values);
    }
}
