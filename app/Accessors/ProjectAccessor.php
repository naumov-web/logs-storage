<?php

namespace App\Accessors;

use App\Repositories\ProjectsRepository;

/**
 * Class ProjectAccessor
 * @package App\Accessors
 */
class ProjectAccessor
{
    /**
     * Projects repository instance
     * @var ProjectsRepository
     */
    protected $repository;

    /**
     * ProjectAccessor constructor.
     */
    public function __construct()
    {
        $this->repository = new ProjectsRepository();
    }

    /**
     * Check access
     *
     * @param string $api_key
     * @return bool
     */
    public function check(?string $api_key) : bool
    {
        return (bool) $this->repository->getByApiKey($api_key);
    }

}
