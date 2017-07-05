<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail
    ];
});

$factory->define(App\Task::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence,
        'completed' => rand(0, 1)
    ];
});
