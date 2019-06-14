<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'titre' => $faker->sentence(5),
        'contenu' => $faker->text(),
        'slug' => str_randomize(10),
        'categorie'=>1,
        'etat' => 0,
        'user' => 1,
    ];
});
