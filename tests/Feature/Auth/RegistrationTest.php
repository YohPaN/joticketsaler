<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->seed(RoleSeeder::class);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'last_name' => 'Test last name',
            'email' => 'test@example.com',
            'password' => 'Password@1',
            'password_confirmation' => 'Password@1',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }
}
