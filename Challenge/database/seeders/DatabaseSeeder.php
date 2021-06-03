<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i=0; $i < 50; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'CPF' => $faker->ean13(),
                'birthday' => $faker->date('Y-m-d'),
                'password' => Hash::make('admin1234'),
            ]);
        }

        for ($i=0; $i < 50; $i++) {
            Transaction::create([
                'amount' => $faker->randomFloat(2, 0, 1000),
                'type' => $faker->randomElement(['credit', 'debt', 'chargeback']),
                'user_id' => $faker->numberBetween(1, 50),
            ]);
        }
    }
}
