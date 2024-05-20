<?php

namespace Tests\Feature;

use App\Http\Middleware\CartIsEmpty;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class CartIsEmptyMiddlewareTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_cart_is_null(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->hasCart()->create();

        $this->actingAs($user);

        $request = Request::create('/cart', 'GET');

        $middleware = new CartIsEmpty;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('Vous ne pouvez pas accèder à cette page car votre panier est vide !', session('empty_cart'));
    }

    public function test_cart_is_empty(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->hasCart(['items' => json_encode([])])->create();

        $this->actingAs($user);

        $request = Request::create('/cart', 'GET');

        $middleware = new CartIsEmpty;

        $response = $middleware->handle($request, function() {});

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('Vous ne pouvez pas accèder à cette page car votre panier est vide !', session('empty_cart'));
    }

    public function test_cart_is_not_empty(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->hasCart(['items' => json_encode([['offer_id' => 1, 'count' => 1]])])->create();

        $this->actingAs($user);

        $request = Request::create('/cart', 'GET');

        $middleware = new CartIsEmpty;

        $response = $middleware->handle($request, function() {});

        $this->assertNull($response);
        // $this->assertEquals('Vous ne pouvez pas accèder à cette page car votre panier est vide !', session('empty_cart'));
    }
}
