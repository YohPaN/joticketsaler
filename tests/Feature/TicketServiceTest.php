<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_missing_item_in_cart(): void
    {
        $this->seed(RoleSeeder::class);

        $user = User::factory()->hasCart()->create([
            'id' => '9c08c85d-df4e-4cb8-b574-18f5a0e8fb2a'
        ]);

        $this->actingAs($user);

        $this->assertFalse((new TicketService)->ticketCreation());
    }
}
