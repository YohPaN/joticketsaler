<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'organisator',
            'last_name' => 'organisator',
            'email' => 'organisator@jo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Xf73x)h%B38~Vt'),
            'remember_token' => Str::random(10),
            'role_id' => 2
        ]);
    }
}
