<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_payment_page(): void
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/payment');

        $response->assertOk();
    }

    public function test_user_can_checkout(): void
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->hasCart()->create();

        $response = $this
            ->actingAs($user)
            ->post('/checkout', [
                'card_number' => '1234123412341234',
                'expiration_date' => '3000-12-12',
                'cvc' => 123,
            ]);

        $this->assertDatabaseCount('tickets', 1);
        $response->assertRedirect('/');
    }
}
