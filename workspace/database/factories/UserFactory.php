<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Member;
use App\Company;
use Illuminate\Support\Str;

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

$factory->define(Member::class, function () {
    $faker = Faker\Factory::create('ja_JP');
    return [
        'id' => (string) Str::uuid(),
        'api_token' => Str::random(60),
        'is_notification' => true,
        'notification_interval' => '0.5h',
        'is_admin' => false,
        'name' => $faker->unique()->name,
        'ruby' => $faker->unique()->kanaName,
        'post' => 'post',
        'tel' => $faker->phoneNumber,
        'company_id' => $faker->randomElement(Company::select('id')->get()),
        'department_name' => $faker->randomElement(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会']),
        'mail' => $faker->safeEmail,
        'password' => Hash::make(Str::random(10))
    ];
});
