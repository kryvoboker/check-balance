<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_return_success_when_come_in() : void
    {
        $this->assertGuest()
            ->get('login')
            ->assertStatus(200);
    }

    public function test_success_login_user()
    {
        $user = $this->createUser();

        $this->post('login', [
            'email' => 'user@gmail.com',
            'password' => 'valid_password_123',
        ])
            ->assertRedirectToRoute('home');

        $this->assertAuthenticatedAs($user);
    }

    public function test_failure_login_user()
    {
        $this->createUser();

        $this->post('login', [
            'email' => 'user@gmail.com',
            'password' => 'failure_password',
        ])
            ->assertSessionHasErrors(['errors']);

        $this->assertGuest();
    }

    /**
     * @return Collection|Model|Authenticatable
     */
    private function createUser() : Collection|false|Authenticatable
    {
        return User::factory()->create([
            'name' => 'test_user_name',
            'lastname' => 'test_user_lastname',
            'email' => 'user@gmail.com',
            'telephone' => '0966906412',
            'password' => 'valid_password_123',
            'status' => true,
        ]);
    }
}
