<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_login_page_return_success_when_come_in() : void
    {
        $response = $this->get('login');

        $response->assertStatus(200);
    }

    public function test_authorized_user_can_go_in_home_page()
    {
        $user = User::factory()->create([
            'name' => 'test_user_name',
            'lastname' => 'test_user_lastname',
            'email' => 'user@gmail.com',
            'telephone' => '0966906412',
            'password' => bcrypt('valid_password_123'),
        ]);

        $response = $this->actingAs($user)
            ->get('/');

        $response->assertOk();
        $response->assertValid(['email', 'password']);
    }
}
