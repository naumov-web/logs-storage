<?php

namespace Tests\Feature\Login;

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

        $response->assertStatus(200);
    }

    /**
     * Test login action, when we are using invalid credentials
     *
     * @test
     * @return void
     */
    public function testLoginFail() : void
    {
        $this->prepareBeforeTests();
    }
}
