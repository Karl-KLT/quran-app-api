<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::create([
        //     'name' => 'user',
        //     'email' => 'mohamed@gmail.com',
        //     'phone_number' => '+201277762205',
        //     'country' => 'ismailia',
        //     'city' => 'egypt',
        //     'password' => \Hash::make('Hcode0110'),
        // ]);

        \App\Models\Service::create([
            'name' => 'preyer time',
            'image' => fake()->imageUrl()
        ]);
    }
}
