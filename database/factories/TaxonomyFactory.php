<?php

use Faker\Generator as Faker;

$factory->define(App\Taxonomy::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->word,
        'slug' => $faker->slug,
        'type' => $faker->word,
        'count' => 5
    ];
});
