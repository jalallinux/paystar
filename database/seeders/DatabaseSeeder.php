<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

         User::factory()->create([
             'name' => 'JalalLinuX',
             'card_number' => '6219861901675354',
             'email' => 'smjjalalzadeh93@gmail.com',
         ]);
    }
}
