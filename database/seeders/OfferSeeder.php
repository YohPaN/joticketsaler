<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offers')->insert([
            'id' => 1,
            'name' => 'solo',
            'price' => 41.23,
            'ticket_number' => 1
        ]);

        DB::table('offers')->insert([
            'id' => 2,
            'name' => 'duo',
            'price' => 78.52,
            'ticket_number' => 2
        ]);

        DB::table('offers')->insert([
            'id' => 3,
            'name' => 'familly',
            'price' => 142.86,
            'ticket_number' => 4
        ]);

    }
}
