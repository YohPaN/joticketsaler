<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds for roles.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin',
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'organisator',
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'user',
        ]);

    }
}
