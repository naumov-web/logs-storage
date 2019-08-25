<?php

namespace App\Services;

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
    protected $users_repository;

    /**
     * UsersService constructor.
     * @param UsersRepository $users_repository
     */
    public function __construct(UsersRepository $users_repository)
    {
        $this->users_repository = $users_repository;
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
