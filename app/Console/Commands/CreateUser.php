<?php

namespace App\Console\Commands;

use App\Services\UsersService;
use Illuminate\Console\Command;

/**
 * Class CreateUser
 * @package App\Console\Commands
 */
class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

    /**
     * Users service instance
     * @var UsersService
     */
    protected $users_service;

    /**
     * Create a new command instance.
     *
     * @param UsersService $users_service
     * @return void
     */
    public function __construct(UsersService $users_service)
    {
        $this->users_service = $users_service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->users_service->create([
            'email' => $email,
            'password' => $password,
        ]);

        $this->info('User successfully created!');
    }
}
