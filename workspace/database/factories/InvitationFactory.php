<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Invitation;
use App\Models\Member;
use Carbon\Carbon;

$factory->define(Invitation::class, function () {
    $faker = Faker\Factory::create('ja_JP');

    $now  = (string) Carbon::now('Asia/Tokyo');             // 現在時刻
    $yestarday = (string) Carbon::yesterday('Asia/Tokyo');  // 昨日

    /* 会のご案内モデル */
    $invitation = [
            '_id' => (string) Str::uuid(),              // 会のご案内のid
            'title' => $faker->realText(32),            // 会のご案内のタイトル
            'text' => $faker->realText,                 // 会のご案内のテキスト
            'images' => [],                             // 会のご案内の画像
            'attend_members' => [],                     // 会のご案内に招待される会員
            'deadline_at' => $yestarday,                // 会のご案内出席の締め切り日
            'created_at' => $now                        // 会のご案内投稿日
        ];

    /* 画像コンテンツの処理 */
    for ($i=0; $i < $faker->numberBetween(1, 5); $i++) {
        /* 画像のuuidを生成 */
        $image_id = (string) Str::uuid();

        // スタンプ画像のパス名をランダムに取得
        $path_name = $faker->randomElement(['stamp1', 'stamp2', 'stamp3', 'stamp4']);

        /* 画像を保存 */
        Storage::putFileAs('private/images/invitations', new File('storage/app/images/' . $path_name . '.png'), $image_id . '.png', 'private');
        
        /* モデルに画像のidを追加 */
        $invitation['images'][] = $image_id;
    }

    /* 会員データと紐づけ */
    $members = Member::get();
    $member_count = Member::get()->count();
    $attend_members = [];

    // 等確率で全会員またはランダムな会員を会のご案内に招待する
    if ($faker->boolean) {
        // ランダムに会員を追加
        $members = $faker->randomElements($members, $faker->numberBetween(1, $member_count-1));
    }

    // 会員と会のご案内データの紐づけ
    foreach ($members as $member) {
        // 会員の_idのみ格納しておく
        $attend_members[] = [
            '_id' => $member->_id,
            'name' => $member->name,
            'ruby' => $member->ruby,
            'status' => '3'
        ];
        $member_invitations = $member['invitations'] ? $member['invitations'] : [];
        array_push($member_invitations, $invitation['_id']);
        $member->invitations = $member_invitations;
        $member->save();
    }

    $invitation['attend_members'] = $attend_members;

    return $invitation;
});
