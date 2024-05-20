<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Database\Seeders\RoleSeeder;
use Exception;
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

    public function test_valide_ticket(): void
    {
        $this->seed(RoleSeeder::class);

        $userId = '9c08c85d-df4e-4cb8-b574-18f5a0e8fb2a';
        $ticketId = '9c08c85d-df4e-4cb8-b574-18f5a0e8fb2b';
        $ticketUserId = $userId.'-'.$ticketId;

        $user = User::factory()->create([
            'id' => $userId
        ]);

        Ticket::factory()->create([
            'id' => $ticketId,
            'ticket_user_id' => $ticketUserId
        ]);

        $ticketServiceResponse = (new TicketService)->ticketValidation(json_encode([$ticketUserId]));

        $this->assertEquals([
            'name' => $user->name,
            'lastName' => $user->last_name,
        ], $ticketServiceResponse);
    }

    public function test_ticket_not_find(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Le ticket n\'a pas été trouvé');
        (new TicketService)->ticketValidation(json_encode(['9c08c85d-df4e-4cb8-b574-18f5a0e8fb2a-9c08c85d-df4e-4cb8-b574-18f5a0e8fb2b']));
    }

    public function test_ticket_already_scanned(): void
    {
        $this->seed(RoleSeeder::class);

        $ticketId = '9c08c85d-df4e-4cb8-b574-18f5a0e8fb2b';

        $user = User::factory()->create([
            'id' => '9c08c85d-df4e-4cb8-b574-18f5a0e8fb2a'
        ]);

        $ticketUserId = $user->id.'-'.$ticketId;

        Ticket::factory()->create([
            'id' => $ticketId,
            'scanned' => true,
            'ticket_user_id' => $ticketUserId,
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Ticket déjà scanné');
        (new TicketService)->ticketValidation(json_encode([$ticketUserId]));
    }
}
