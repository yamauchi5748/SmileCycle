<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Member;
use App\Models\Forum;
use Carbon\Carbon;

$factory->define(Forum::class, function () {
    $faker = Faker\Factory::create('ja_JP');

    $now  = (string) Carbon::now('Asia/Tokyo'); // 現在時刻
    $members = Member::get();
    $member = $faker->randomElement($members);

    /* 掲示板のモデル */
    $forum = [
        '_id' => (string) Str::uuid(),      // 掲示板のid
        'sender_id' => $member->_id,        // 掲示板の投稿者id
        'sender_name' => $member->name,     // 掲示板の投稿者名
        'title' => $faker->realText(20),    // 掲示板のタイトル
        'text' => $faker->realText,         // 掲示板のテキスト
        'images' => [],                     // 掲示板の画像
        'comments' => [],                   // 掲示板のコメント
        'created_at' => $now                // 掲示板投稿日
    ];

    /* 画像コンテンツの処理 */
    for ($i=0; $i < $faker->numberBetween(0, 5); $i++) {
        /* 画像のuuidを生成 */
        $image_id = (string) Str::uuid();

        // 画像のパス名をランダムに取得
        $path_name = $faker->randomElement(['boy_1', 'boy_2', 'boy_3']);

        /* 画像を保存 */
        Storage::putFileAs('public/images/forums', new File('storage/app/images/' . $path_name . '.png'), $image_id . '.png', 'private');
        
        /* モデルに画像のidを追加 */
        $forum['images'][] = $image_id;
    }

    // モデルをDBに登録
    return $forum;
});
