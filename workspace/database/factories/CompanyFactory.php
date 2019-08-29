<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Company;
use Illuminate\Support\Str;

$factory->define(Company::class, function () {
    $faker = Faker\Factory::create('ja_JP');
    return [
        'id' => (string) Str::uuid(),
        'name' => $faker->company,
        'address' => $faker->address,
        'fax' => 'xxx-xxxx-xxxx',
        'tel' => $faker->phoneNumber
    ];
});
