<?php

namespace App\Services;

use App\Repositories\AbstractRepository;
use App\Repositories\ProjectsRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class ProjectsService
 * @package App\Services
 */
class ProjectsService extends AbstractService
{

    /**
     * Projects repository instance
     * @var ProjectsRepository
     */
    protected $projects_repository;

    /**
     * ProjectsService constructor.
     *
     * @param ProjectsRepository $projects_repository
     */
    public function __construct(ProjectsRepository $projects_repository)
    {
        $this->projects_repository = $projects_repository;
    }

    /**
     * Get repository instance
     *
     * @return AbstractRepository
     */
    protected function getRepository(): AbstractRepository
    {
        return $this->projects_repository;
    }

    /**
     * Store new project
     *
     * @param array $data
     * @return Model
     */
    public function store(array $data): Model
    {
        $model_data = array_merge(
            $data,
            [
                'api_key' => hash('sha512', $data['name'] . microtime())
            ]
        );

        return parent::store($model_data);
    }

    /**
     * Update project
     *
     * @param Model $model
     * @param array $data
     * @return Model
     */
    public function update(Model $model, array $data) : Model
    {
        return parent::update($model, Arr::except($data, ['api_key']));
    }
}
