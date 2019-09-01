<?php

namespace App\Services;

use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class AbstractService
 * @package App\Services
 */
abstract class AbstractService
{
    /**
     * Get repository instance
     *
     * @return AbstractRepository
     */
    protected abstract function getRepository() : AbstractRepository;

    /**
     * Default implementation of storing of data to database
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data) : Model
    {
        return $this->getRepository()->store($data);
    }

    /**
     * Get models list
     *
     * @param array $data
     * @return array
     */
    public function index(array $data) : array
    {
        return $this->getRepository()->index($data);
    }

    /**
     * Show one model
     *
     * @param Model $model
     * @return Model
     */
    public function show(Model $model) : Model
    {
        return $model;
    }

    /**
     * Default implementation of updating of data to database
     *
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data) : Model
    {
        return $this->getRepository()->update(
            $model,
            Arr::except($data, ['api_key'])
        );
    }
}
