<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'id'=> 1,
        'customer_name'=> $faker->name(),
        'customer_email'=> $faker->email,
        'customer_mobile'=> $faker->phoneNumber,
        'status'=> $faker->randomElement(['CREATED', 'PAYED','REJECTED']),
        'product_id'=> $faker->randomNumber(1),
        'price'=> $faker->randomFloat(2,10000,90000),
    ];
});
