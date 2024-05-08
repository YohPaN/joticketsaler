<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_offer(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['role_id' => 1]);

        $response = $this
            ->actingAs($user)
            ->post('offer', [
                'name' => 'Test Offer',
                'price' => 12.23,
                'ticket_number' => 1,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/admin');

        $this->assertDatabaseHas('offers', [
            'name' => 'Test Offer',
            'price' => 12.23,
            'ticket_number' => 1,
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_update_offer(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['role_id' => 1]);

        $offer = Offer::factory()->create([
            'name' => 'Test Offer',
            'price' => 12.23,
            'ticket_number' => 2,
        ]);
        $response = $this
            ->actingAs($user)
            ->put('offer', [
                'id' => $offer->id,
                'name' => 'Offer',
                'price' => 12.26,
                'ticket_number' => 1,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/admin');

        $this->assertDatabaseHas('offers', [
            'name' => 'Offer',
            'price' => 12.26,
            'ticket_number' => 1,
        ]);
    }

    public function test_delete_offer(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(['role_id' => 1]);

        $offer = Offer::factory()->create([
            'name' => 'Test Offer',
            'price' => 12.23,
            'ticket_number' => 2,
        ]);
        $response = $this
            ->actingAs($user)
            ->delete('offer/'.$offer->id);

        $response
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('offers', [
            'id' => $offer->id,
        ]);
    }
}
