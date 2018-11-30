<?php

use App\Models\Album;
use App\Models\Photo;
use Faker\Generator as Faker;

$factory->define(App\Models\Photo::class, function (Faker $faker) {
    return [
        'album_id' => Album::inRandomOrder()->first()->id,
        'name' => $faker->text(64),
        'description' => $faker->text(128),
        'img_path' => $faker->imageUrl(640, 480, $faker->randomElement(['animals', 'business'])),
    ];
});
