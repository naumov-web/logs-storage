<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 * @package App\Repositories
 */
abstract class AbstractRepository
{
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

}
