<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $gender = $faker->randomElement(['male','female']);

    return [
        'name'              => $gender=='male'?$faker->firstNameMale:$faker->firstNameFemale,
        'last_name'         => $faker->lastName,
        'email'             => $faker->unique()->safeEmail,
        'password'          => $password ?: $password = bcrypt('secret'),
        'gender'            => $gender,
        'birth_date'        => $faker->date('Y-m-d'),
        'status'            => $faker->boolean(),
        'role_id'           => 1,
        'remember_token'    => str_random(10),
    ];
});