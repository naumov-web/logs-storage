<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UsersRepository
 * @package App\Repositories
 */
class UsersRepository extends AbstractRepository
{
    /**
     * Get model class name
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return User::class;
    }
}
