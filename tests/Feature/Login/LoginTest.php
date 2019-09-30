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
     * @return void
     */
    public function testRenderPage()
    {
        $response = $this->get(route('login.form'));

        $response->assertStatus(200);
    }
}
