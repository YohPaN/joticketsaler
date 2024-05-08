<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_admin(): void
    {
        $this->seed(RoleSeeder::class);

        $newUser = User::factory()->create([
            'role_id' => 1,
        ]);

        $this->actingAs($newUser);

        $this->assertTrue($newUser->isAdmin());
    }

    public function test_user_is_not_admin(): void
    {
        $this->seed(RoleSeeder::class);

        $newUser = User::factory()->create([
            'role_id' => 2,
        ]);

        $this->actingAs($newUser);

        $this->assertFalse($newUser->isAdmin());
    }
    public function test_user_is_organisator(): void
    {
        $this->seed(RoleSeeder::class);

        $newUser = User::factory()->create([
            'role_id' => 2,
        ]);

        $this->actingAs($newUser);

        $this->assertTrue($newUser->isOrganisator());
    }

    public function test_user_is_not_organisator(): void
    {
        $this->seed(RoleSeeder::class);

        $newUser = User::factory()->create([
            'role_id' => 1,
        ]);

        $this->actingAs($newUser);

        $this->assertFalse($newUser->isOrganisator());
    }

    public function test_users_belongTo_relation_with_roles(): void
    {
        $this->seed(RoleSeeder::class);
        $role_id = 1;

        $user = User::factory()->create([
            'role_id' => $role_id,
        ]);

        $this->assertTrue($user->role->id === Role::find($role_id)->id);
    }

    public function test_roles_hasMany_relation_with_users(): void
    {
        $this->seed(RoleSeeder::class);

        $role = Role::find(1);

        User::factory()->count(3)->for($role)->create();

        $this->assertCount(3, $role->users);
    }
}
