<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Member;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Member::class, function (Faker $faker) {
    return [
        'id' => (string) Str::uuid(),
        'api_token' => Str::random(60),
        'is_notification' => true,
        'notification_interval' => '0.5h',
        'is_admin' => false,
        'ruby' => 'unti',
        'post' => 'post',
        'tel' => $faker->phoneNumber,
        'company_id' => 'company_id',
        'department_name' => 'department_name',
        'name' => $faker->unique()->name,
        'mail' => $faker->safeEmail,
        'password' => Hash::make(Str::random(10)),
        'remember_token' => Str::random(10),
    ];
});
