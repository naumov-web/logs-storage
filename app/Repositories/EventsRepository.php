<?php

namespace App\Repositories;

use App\Models\Log;

/**
 * Class EventsRepository
 * @package App\Repositories
 */
class EventsRepository extends AbstractRepository
{

    /**
     * Get model class
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return Log::class;
    }
}
