<?php

namespace App\Services;

use App\Models\Log;
use App\Repositories\AbstractRepository;
use App\Repositories\LogsRepository;
use App\Repositories\ProjectsRepository;

/**
 * Class LogsService
 * @package App\Services
 */
class LogsService extends AbstractService
{

    /**
     * Logs repository instance
     * @var LogsRepository
     */
    protected $repository;
    /**
     * @var ProjectsRepository
     */
    protected $projects_repository;

    /**
     * LogsService constructor.
     * @param LogsRepository $repository
     * @param ProjectsRepository $projects_repository
     */
    public function __construct(LogsRepository $repository, ProjectsRepository $projects_repository)
    {
        $this->repository = $repository;
        $this->projects_repository = $projects_repository;
    }

    /**
     * @inheritDoc
     */
    protected function getRepository(): AbstractRepository
    {
        return $this->repository;
    }

    /**
     * Get logs records
     *
     * @param array $data
     * @return array
     */
    public function index(array $data): array
    {
        return $this->getRepository()->index($data);
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
