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

        $this->assertGuest();
        $response->assertStatus(200);
    }

    public function test_create_user()
    {
        User::factory()->create([
            'name' => 'test_user_name',
            'lastname' => 'test_user_lastname',
            'email' => 'user@gmail.com',
            'telephone' => '0966906412',
            'password' => 'valid_password_123',
            'status' => true
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@gmail.com'
        ]);
    }
}
