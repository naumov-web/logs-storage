<?php

namespace App\Repositories;

use App\Models\ProjectEventType;

/**
 * Class ProjectEventTypesRepository
 * @package App\Repositories
 */
class ProjectEventTypesRepository extends AbstractRepository
{
    /**
     * Get model class name
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return ProjectEventType::class;
    }
}
