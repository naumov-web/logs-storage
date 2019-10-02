<?php

namespace Tests\Feature\Login;

use Illuminate\Http\Response;
use Tests\Feature\BaseAccountTest;

/**
 * Class LoginTest
 * @package Tests\Feature
 */
class LoginTest extends BaseAccountTest
{

    /**
     * A basic test example.
     *
     * @test
     * @return void
     */
    public function testRenderPage() : void
    {
        $response = $this->get(route('login.form'));

        $response->assertStatus(200)
            ->assertSee('Авторизация');
    }

    /**
     * Test login action, when we are using invalid credentials
     *
     * @test
     * @return void
     */
    public function testLoginFail()
    {
        $this->createAdmin();

        $response = $this->post(
            route('login'),
            [
                'email' => $this->admin_data['email'],
                'password' => '123'
            ]
        );
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response = $this->post(
            route('login'),
            [
                'email' => 'admin2@admin.com',
                'password' => '123456'
            ]
        );
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test login action, when we are using valid credentials
     *
     * @test
     * @return void
     */
    public function testLoginSuccess() : void
    {
        $this->createAdmin();

        $response = $this->post(route('login'), $this->admin_data);
        $response->assertStatus(302);
    }
}
