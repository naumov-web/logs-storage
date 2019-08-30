<?php

namespace App\Services;

use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

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
        $repository = $this->getRepository();

        return $repository->store($data);
    }
}
