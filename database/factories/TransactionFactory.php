<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'amount' => $faker->numberBetween(1, 1000),
        'type' => $faker->randomElement(['debit', 'credit', 'reversal']),
    ];
});
