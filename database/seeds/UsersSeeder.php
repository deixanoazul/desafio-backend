<?php

use App\Models\User;
use App\Models\Transaction;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
        factory(User::class, 5)->create()->each(function (User $user) {
            $user->transactions()->saveMany(
                factory(Transaction::class, 3)->make()
            );
        });
    }
}
