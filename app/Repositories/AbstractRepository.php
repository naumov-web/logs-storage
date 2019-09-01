<?php

namespace App\Repositories;

use App\Repositories\Traits\ApplyPagination;
use App\Repositories\Traits\ApplySimpleSorting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class AbstractRepository
 * @package App\Repositories
 */
abstract class AbstractRepository
{

    use ApplyPagination, ApplySimpleSorting;

    /**
     * Get model class
     *
     * @return string
     */
    protected abstract function getModelClass() : string;

    /**
     * Store simple model
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data) : Model
    {
        $class = $this->getModelClass();
        $model = new $class();
        $model->fill($data);
        $model->save();
        $model->fresh();

        return $model;
    }

    /**
     * Get items
     *
     * @param array $data
     * @return array
     */
    public function index(array $data) : array
    {
        $class = $this->getModelClass();

        /**
         * @var Builder
         */
        $query = $class::query();

        $count = $query->count();

        $this->applyPagination($query, $data);
        $this->applySimpleSorting($query, $data);

        return [
            'items' => $query->get(),
            'count' => $count,
        ];
    }

}
