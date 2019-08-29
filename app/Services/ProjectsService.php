<?php

namespace App\Services;

use App\Repositories\ProjectsRepository;

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
}
