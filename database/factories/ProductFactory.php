<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'id' => "1",
        'name' => "1",
        'price' => $faker->randomFloat(2,10000,90000),
    ];
});
