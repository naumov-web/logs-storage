<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\UsersRepository;
use App\Services\UsersService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BaseAccountTest
 * @package Tests\Feature
 */
abstract class BaseAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * Admin user data
     * @var array
     */
    protected $admin_data = [
        'email' => 'admin@admin.com',
        'password' => '123456',
    ];

    /**
     * Users service instance
     * @var UsersService
     */
    protected $users_service;

    /**
     * BaseAccountTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->users_service = new UsersService(
            new UsersRepository()
        );
    }

    /**
     * Create admin user
     *
     * @return void
     */
    protected function createAdmin() : void
    {
        $this->users_service->create($this->admin_data);
        $this->user = User::query()->where('email', $this->admin_data['email'])->first();
    }

    /**
     * Set user as signed
     *
     * @return void
     */
    protected function signInUser() : void
    {
        $this->actingAs($this->user);
    }

    /**
     * Prepare before tests
     *
     * @return void
     */
    protected function prepareBeforeTests() : void
    {
        $this->createAdmin();
        $this->signInUser();
    }

}
