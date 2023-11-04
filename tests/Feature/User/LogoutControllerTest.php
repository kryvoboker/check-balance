<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_user() : void
    {
        $user = User::factory()->create([
            'name' => 'test_user_name',
            'lastname' => 'test_user_lastname',
            'email' => 'user@gmail.com',
            'telephone' => '0966906412',
            'password' => 'valid_password_123',
            'status' => true,
        ]);

        $this->post('login', [
            'email' => 'user@gmail.com',
            'password' => 'valid_password_123',
        ])
            ->assertRedirectToRoute('home');

        $this->assertAuthenticatedAs($user)
            ->get('logout')
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }
}
