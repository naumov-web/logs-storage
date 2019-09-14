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

    /**
     * Get project by access key
     *
     * @param string|null $api_key
     * @return Project
     */
    public function getByApiKey(?string $api_key) : ?Project
    {
        return Project::where('api_key', $api_key)->first();
    }
}
