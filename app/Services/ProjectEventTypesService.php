<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\AbstractRepository;
use App\Repositories\ProjectEventTypesRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectEventTypesService
 * @package App\Services
 */
class ProjectEventTypesService extends AbstractService
{
    protected $repository;

    /**
     * ProjectsService constructor.
     *
     * @param ProjectEventTypesRepository $repository
     */
    public function __construct(ProjectEventTypesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get repository instance
     *
     * @return AbstractRepository
     */
    protected function getRepository(): AbstractRepository
    {
        return $this->repository;
    }

    /**
     * Create new project event type
     *
     * @param Project $project
     * @param array $data
     * @return Model
     */
    public function create(Project $project, array $data): Model
    {
        return parent::store(array_merge(['project_id' => $project->id], $data));
    }

    /**
     * Get all project event types
     *
     * @param Project $project
     * @param array $data
     * @return array
     */
    public function get(Project $project, array $data) : array
    {
        return parent::index(array_merge(['project_id' => $project->id], $data));
    }
}
