<?php

use App\Models\Album;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Album::class, function (Faker $faker) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text,
        'user_id' => User::inRandomOrder()->first()->id,
        'album_thumb' => $faker->imageUrl(640, 480, $faker->randomElement(['animals', 'business'])),
    ];
});
