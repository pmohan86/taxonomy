<?php

use Faker\Generator as Faker;

$factory->define(App\Taxonomy::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->word,
        'slug' => $faker->slug,
        'type' => $faker->word,
        'parent' => function () {
            if (rand(0, 1)) {
                return factory('App\Taxonomy')->create();
            }
            return null;
        },
        'count' => 5
    ];
});
