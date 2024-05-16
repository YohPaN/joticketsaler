<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use Database\Seeders\OfferSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use stdClass;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item_in_cart_where_cart_is_null(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(OfferSeeder::class);

        $items = [];
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 1;
        array_push($items, $item);

        $user = User::factory()->hasCart(['id' => 1])->create();

        $response = $this
            ->actingAs($user)
            ->post('cart', [
                'id' => 1,
            ]);

        $response->assertSessionHasNoErrors();

        $databaseItem =json_decode(Cart::find(1)->items);

        $this->assertEquals($items, $databaseItem);
    }

    public function test_add_item_in_cart_where_item_is_not_present_in_cart(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(OfferSeeder::class);

        $items = [];
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 2;
        array_push($items, $item);

        $newItems = [];
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 2;
        array_push($newItems, $item);
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 1;
        array_push($newItems, $item);

        $user = User::factory()->hasCart(['id' => 1, 'items' => json_encode($items)])->create();

        $response = $this
            ->actingAs($user)
            ->post('cart', [
                'id' => 1,
            ]);

        $response->assertSessionHasNoErrors();

        $databaseItem =json_decode(Cart::find(1)->items);

        $this->assertEquals($newItems, $databaseItem);
    }

    public function test_add_item_in_cart_where_item_is_present_in_cart(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(OfferSeeder::class);

        $items = [];
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 1;
        array_push($items, $item);

        $newItems = [];
        $item = new stdClass();
        $item->count = 2;
        $item->offer_id = 1;
        array_push($newItems, $item);

        $user = User::factory()->hasCart(['id' => 1, 'items' => json_encode($items)])->create();

        $response = $this
            ->actingAs($user)
            ->post('cart', [
                'id' => 1,
            ]);

        $response->assertSessionHasNoErrors();

        $databaseItem =json_decode(Cart::find(1)->items);

        $this->assertEquals($newItems, $databaseItem);
    }

    public function test_show_cart(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(OfferSeeder::class);
        $user = User::factory()->hasCart(['items' => json_encode([['offer_id' => 1, 'count' => 1]])])->create();

        $response = $this
            ->actingAs($user)
            ->get('cart');

        $response
            ->assertSessionHasNoErrors()
            ->assertOk();
    }

    public function test_delete_item_in_cart(): void
    {
        $this->seed(RoleSeeder::class);
        $this->seed(OfferSeeder::class);
        $user = User::factory()->hasCart()->create();

        $items = [];
        $item = new stdClass();
        $item->count = 1;
        $item->offer_id = 1;
        array_push($items, $item);

        Cart::create([
            'items' => json_encode($items),
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->delete('cart/1');

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('carts', [
            'items' => json_encode($items),
        ]);
    }
}
