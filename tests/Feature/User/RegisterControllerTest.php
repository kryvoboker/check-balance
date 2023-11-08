<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_return_success_when_come_in() : void
    {
        $this->assertGuest()
            ->get('register')
            ->assertStatus(200);
    }

    public function test_failure_register_user()
    {
        $user_data = $this->takeUserData();

        $user_data['password_confirmation'] = 'valid_password';

        $this->post('/register', $user_data)
            ->assertSessionHasErrors(['password']);

        $this->assertDatabaseMissing('users', [
            'email' => 'user1@gmail.com',
        ]);
    }

    public function test_success_register_user()
    {
        $user_data = $this->takeUserData();

        $this->post('/register', $user_data)
            ->assertRedirectToRoute('success_register')
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => 'user@gmail.com',
            'status' => 0,
        ]);

        $this->assertGuest();
    }

    /**
     * @return string[]
     */
    private function takeUserData() : array
    {
        return [
            'name' => 'test_user_name',
            'lastname' => 'test_user_lastname',
            'email' => 'user@gmail.com',
            'telephone' => '0966906412',
            'password' => 'valid_password_123',
            'password_confirmation' => 'valid_password_123',
        ];
    }
}
