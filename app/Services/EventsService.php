<?php

namespace App\Services;

use App\Models\Log;
use App\Repositories\AbstractRepository;
use App\Repositories\EventsRepository;
use App\Repositories\ProjectsRepository;

/**
 * Class EventsService
 * @package App\Services
 */
class EventsService extends AbstractService
{
    /**
     * Event repository instance
     * @var EventsRepository
     */
    protected $repository;

    /**
     * Projects repository instance
     * @var ProjectsRepository
     */
    protected $projects_repository;

    /**
     * EventsService constructor.
     * @param EventsRepository $repository
     * @param ProjectsRepository $projects_repository
     */
    public function __construct(EventsRepository $repository, ProjectsRepository $projects_repository)
    {
        $this->repository = $repository;
        $this->projects_repository = $projects_repository;
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
     * Create new event item
     *
     * @param array $data
     * @return Log
     */
    public function create(array $data) : Log
    {
        $model_data = $data;
        $model_data['project_id'] = $this->projects_repository->getByApiKey($data['api_key'])->id;
        $model_data['event_date'] = date('Y-m-d');
        $model_data['event_time'] = date('Y-m-d H:i:s');
        unset($model_data['api_key']);

        return $this->getRepository()->store($model_data);
    }
}
