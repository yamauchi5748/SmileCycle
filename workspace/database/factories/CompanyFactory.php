<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Company;
use Illuminate\Support\Str;

$factory->define(Company::class, function () {
    $faker = Faker\Factory::create('ja_JP');
    return [
        '_id' => (string) Str::uuid(),
        'name' => $faker->company,
        'address' => $faker->address,
        'fax' => 'xxx-xxxx-xxxx',
        'telephone_number' => $faker->phoneNumber,
        'members' => []
    ];
});
