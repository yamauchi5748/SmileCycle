<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\StampGroup;

$factory->define(StampGroup::class, function () {
    $faker = Faker\Factory::create('ja_JP');

    // タブ画像を生成
    $tab_image_id = (string) Str::uuid();
    $path_name = $faker->randomElement(['stamp1', 'stamp2', 'stamp3', 'stamp4']);

    /* タブ画像を保存 */
    Storage::putFileAs('private/images/stamps', new File('storage/app/images/' . $path_name . '.png'), $tab_image_id . '.png', 'private');

    // スタンプをランダムに生成
    $stamps = [];
    for ($i=0; $i < $faker->numberBetween(1, 10); $i++) {
        $stamp_id = (string) Str::uuid();

        // スタンプ画像のパス名をランダムに取得
        $path_name = $faker->randomElement(['stamp1', 'stamp2', 'stamp3', 'stamp4']);

        // スタンプ画像をストレージに保存
        Storage::putFileAs('private/images/stamps', new File('storage/app/images/' . $path_name . '.png'), $stamp_id . '.png', 'private');
        
        $stamps[] = $stamp_id;
    }

    return [
        '_id' => (string) Str::uuid(),  
        'tab_image_id' => $tab_image_id,           
        'is_all' => $faker->boolean,   
        'stamps' => $stamps,                 
        'members' => []
    ];
});
