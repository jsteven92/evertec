<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\OrderPayMent;
use Faker\Generator as Faker;

$factory->define(OrderPayMent::class, function (Faker $faker) {
    return [
        'id'=>1,
        'order_id'=>1,
        'request_id'=>1,
        'process_url'=>$faker->url,
        'internal_reference'=>$faker->randomNumber(5),
        'status'=>$faker->randomElement(['PENDING','PAYED','EXPIRED','REJECTED']),
        'called_api_at'=>$faker->dateTime()->format('Y-m-d H:i:s'),
    ];
});
