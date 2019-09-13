<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Member;
use App\Models\Company;
use App\Models\StampGroup;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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

    $_id = (string) Str::uuid();

    /* 会社データと紐づけ */
    $company_id = $faker->randomElement(Company::select()->get())->_id;
    $company = Company::where('_id', $company_id)->first();

    $members = $company->members;
    array_push($members, $_id);
    $company->members = $members;
    $company->save();

    /* スタンプグループデータと紐づけ */
    $private_stamp_groups_obj = StampGroup::where('is_all', false)->get();
    $public_stamp_groups_obj = StampGroup::where('is_all', true)->get();
    $private_stamp_groups_count = StampGroup::where('is_all', false)->get()->count();
    $stamp_groups_id = [];

    // ランダムにスタンプグループを追加
    $stamp_groups = $faker->randomElements($private_stamp_groups_obj, $faker->numberBetween(1, $private_stamp_groups_count));

    // スタンプグループにmemberを追加
    foreach ($stamp_groups as $stamp_group) {
        $stamp_group_members = $stamp_group->members;
        array_push($stamp_group_members, $_id);
        $stamp_group->members = $stamp_group_members;
        $stamp_group->save();
    }

    // スタンプグループの_idのみ配列に格納
    foreach ($stamp_groups as $stamp_group) {
        $stamp_groups_id[] = $stamp_group->_id;
    }
    foreach ($public_stamp_groups_obj as $stamp_group) {
        $stamp_groups_id[] = $stamp_group->_id;
    }

    // プロフィール画像のパス名をランダムに取得
    $path_name = $faker->randomElement(['boy_1', 'boy_2', 'boy_3']);

    // 会員のプロフィール画像をストレージに保存
    Storage::putFileAs('private/images/profile_images/', new File('storage/app/images/' . $path_name . '.png'), $_id . '.png', 'private');

    return [
        '_id' => $_id,
        'api_token' => Str::random(60),
        'is_notification' => true,
        'notification_interval' => '0.5h',
        'is_admin' => false,
        'name' => $faker->unique()->name,
        'ruby' => $faker->unique()->kanaName,
        'post' => $faker->randomElement(['社長', '会長', '取締役', '社員']),
        'telephone_number' => $faker->phoneNumber,
        'department_name' => $faker->randomElement(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会']),
        'stamp_groups' => $stamp_groups_id,
        'invitations' => [],
        'mail' => $faker->safeEmail,
        'password' => Hash::make(Str::random(10))
    ];
});
