<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\StampGroup;
use App\Models\ChatRoom;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\Carbon;

class PersonalChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');
        $members = Member::select('_id', 'name')->get();
        $member_count = Member::get()->count();

        for ($i=0; $i < $member_count-1; $i++) {
            for ($j=$i+1; $j < $member_count; $j++) {
                /** チャットグループ作成 **/
                // モデル作成
                $chat_group = [
                    '_id' => (string) Str::uuid(),
                    'is_group' => 0,
                    'is_department' => 0,
                    'admin_member_id' => $members[$i]['_id'],
                    'group_name' => '',
                    'members' => [
                        [
                            '_id' => $members[$i]['_id'],
                            'name' => $members[$i]['name'],
                        ],
                        [
                            '_id' => $members[$j]['_id'],
                            'name' => $members[$j]['name'],
                        ]
                    ],
                    'contents' => [],
                    'created_at' => (string) Carbon::now('Asia/Tokyo')
                ];

                // 画像のパス名をランダムに取得
                $path_name = $faker->randomElement(['chat', 'chat_purple', 'chat_blue', 'chat_green']);

                // チャットグループのアイコン画像をストレージに保存
                Storage::putFileAs('private/images/chats', new File('storage/app/images/' . $path_name . '.png'), $chat_group['_id'] . '.png', 'private');

                /** チャットコンテンツ投稿 **/
                for ($k=0; $k < $faker->numberBetween(1, 2); $k++) {
                    $second = $k < 10 ? '0'.$k : $k;
                    $now  = (string) Carbon::createFromFormat('Y-m-d H:i', '2019-09-10 19:' . $second, 'Asia/Tokyo');
                    $now = Str::limit($now, 16, '');
                    $chat_member = $faker->randomElement($chat_group['members']);
        
                    /* チャットモデル */
                    $chat = [
                        '_id' => (string) Str::uuid(),
                        'is_hurry' => $faker->numberBetween(0, 1),
                        'content_type' => $faker->randomElement(["1", "2", "3"]),
                        'sender_id' => $chat_member['_id'],
                        'sender_name' => $chat_member['name'],
                        'created_at' => $now,
                        'already_read' => []
                    ];

                    // チャットコンテンツのタイプによって処理
                    switch ($chat['content_type']) {
                        case '1':
                            // メッセージ
                            $chat['message'] = $faker->realText;
                            break;
                        case '2':
                            // スタンプ
                            $stamps = StampGroup::select('stamps')->where('is_all', 1)->get();
                            $stamp = $faker->randomElement($stamps)->stamps[0];
                            $chat['stamp_id'] = $stamp;
                            break;
                        case '3':
                            // 画像
                            /* 画像のuuidを生成 */
                            $image_id = (string) Str::uuid();
                
                            // 画像のパス名をランダムに取得
                            $path_name = $faker->randomElement(['boy_1', 'boy_2', 'boy_3']);

                            /* 画像を保存 */
                            Storage::putFileAs('private/images/chats', new File('storage/app/images/' . $path_name . '.png'), $image_id . '.png', 'private');
                        
                            /* モデルに画像のidを追加 */
                            $chat['content_id'] = $image_id;
                            break;
                        case '4':
                            // 動画
                            /* 動画のuuidを生成 */
                            $video_id = (string) Str::uuid();

                            // 画像のパス名をランダムに取得
                            $path_name = $faker->randomElement(['video1', 'video2', 'video3']);
                
                            /* 動画を保存 */
                            Storage::putFileAs('private/videos/', new File('storage/app/videos/' . $path_name . '.mp4'), $video_id . '.mp4', 'private');
                        
                            /* モデルに動画のidを追加 */
                            $chat['content_id'] = $video_id;
                            break;
                    }
                    $chat_group['contents'][] = $chat;
                }
                $chat_group['contents'] = collect($chat_group['contents'])->reverse()->values()->toArray();
                ChatRoom::create($chat_group);
            }
        }
    }
}
