<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Member;
use App\Models\Forum;
use App\Models\StampGroup;
use Carbon\Carbon;

$factory->define(Forum::class, function () {
    $faker = Faker\Factory::create('ja_JP');

    $time = '2019-09-10 17:' . $faker->numberBetween(10, 59);
    $now  = (string) Carbon::createFromFormat('Y-m-d H:i', $time); // 現在時刻
    $now = Str::limit($now, 16, '');
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
        Storage::putFileAs('private/images/forums', new File('storage/app/images/' . $path_name . '.png'), $image_id . '.png', 'private');
        
        /* モデルに画像のidを追加 */
        $forum['images'][] = $image_id;
    }

    /* コメント追加処理 */
    for ($i=0; $i < $faker->numberBetween(0, 20); $i++) {
        $commenter = $faker->randomElement($members);
        $stamp_groups = StampGroup::whereIn('members', [$commenter->_id])->get();
        $stamps = $faker->randomElement($stamp_groups)->stamps;

        $second = $i < 10 ? '0'.$i : $i;
        $now  = (string) Carbon::createFromFormat('Y-m-d H:i', '2019-09-10 19:' . $second, 'Asia/Tokyo'); // 現在時刻
        $now = Str::limit($now, 16, '');

        /* コメントのモデル */
        $comment = [
            '_id' => (string) Str::uuid(),                          // コメントのid
            'sender_id' => $commenter->_id,                         // コメントの投稿者id
            'sender_name' => $commenter->name,                      // コメントの投稿者名
            'comment_type' => $faker->randomElement(["1", "2"]),    // コメントのタイプ
            'created_at' => $now                                    // コメント投稿日
        ];

        /* コメントタイプ別に処理 */
        if ($comment['comment_type'] == 1) {
            /* テキスト */
            $comment['text'] = $faker->realText;
        } elseif ($comment['comment_type'] == 2) {
            /* スタンプ */
            $comment['stamp_id'] = $faker->randomElement($stamps);
        }

        /* モデルにコメントを追加 */
        $forum['comments'][] = $comment;
    }
    $forum['comments'] = collect($forum['comments'])->reverse()->values()->toArray();

    // モデルをDBに登録
    return $forum;
});
