<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_guest_from_main_page(): void
    {
        $this->assertGuest();

        $this->get('/')
            ->assertRedirectToRoute('login');
    }

    public function test_authenticated_user_can_come_in_main_page()
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

        $this->assertAuthenticatedAs($user);

        $this->get('/')
            ->assertStatus(200);
    }
}
