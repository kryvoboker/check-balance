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
            ->assertRedirectToRoute('costs.index');

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

    public function test_access_denied_for_bad_user()
    {
        $this->createUser();

        $this->assertDatabaseHas('users', [
            'email' => 'user@gmail.com'
        ]);

        $user_login_data = [
            'ip_address' => '127.0.0.1',
            'email' => 'user@gmail.com',
            'number_of_tries' => 3,
        ];

        User\UserLogin::create($user_login_data);

        $this->assertDatabaseHas('user_logins', $user_login_data);

        $this->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
            ->post('login', [
                'email' => 'user@gmail.com',
                'password' => 'valid_password_123',
            ])
            ->assertForbidden();

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
