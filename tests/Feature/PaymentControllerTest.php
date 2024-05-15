<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OfferSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use stdClass;
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

    public function test_user_cant_checkout_with_empty_cart(): void
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

        $response->assertSessionHasErrorsIn('payment_error');
        $response->assertRedirect(session()->previousUrl());
    }

    public function test_user_can_checkout_with_fill_cart(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(OfferSeeder::class);

        $user = User::factory()->hasCart()->create();

        $items = [];
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 1;
        array_push($items, $item);

        $user->cart->items = json_encode($items);

        $response = $this
            ->actingAs($user)
            ->post('/checkout', [
                'card_number' => '1234123412341234',
                'expiration_date' => '3000-12-12',
                'cvc' => 123,
            ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success_payment');
    }
}
