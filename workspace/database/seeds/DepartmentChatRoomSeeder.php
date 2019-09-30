<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\ChatRoom;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DepartmentChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');

        $admin = Member::where('name', 'admin')->first();
        $departments_name = ['東京笑門会', '鎌倉笑門会', '愛媛笑門会', '大阪笑門会'];

        /** チャットグループ作成 **/
        foreach ($departments_name as $department_name) {
            // モデル作成
            $chat_group = [
                '_id' => (string) Str::uuid(),
                'is_group' => true,
                'is_department' => true,
                'admin_member_id' => $admin['_id'],
                'group_name' => $department_name,
                'members' => [],
                'contents' => [],
            ];
            
            // 画像のパス名をランダムに取得
            $path_name = $faker->randomElement(['boy_1', 'boy_2', 'boy_3']);

            // チャットグループのアイコン画像をストレージに保存
            Storage::putFileAs('private/images/chats', new File('storage/app/images/' . $path_name . '.png'), $chat_group['_id'] . '.png', 'private');

            ChatRoom::create($chat_group);
        }
    }
}
