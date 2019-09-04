<?php

namespace App\Services;

use App\Repositories\AbstractRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsersService
 * @package App\Services
 */
class UsersService extends AbstractService
{

    /**
     * Users repository instance
     * @var UsersRepository
     */
    protected $repository;

    /**
     * UsersService constructor.
     * @param UsersRepository $repository
     */
    public function __construct(UsersRepository $repository)
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
     * Create user
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $model_data = $data;
        $model_data['password'] = Hash::make($data['password']);

        return $this->users_repository->store($model_data);
    }
}
