<?php

namespace App\Repositories;

use App\Models\Project;

/**
 * Class ProjectsRepository
 * @package App\Repositories
 */
class ProjectsRepository extends AbstractRepository
{
    /**
     * Get model class name
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Project::class;
    }
}
