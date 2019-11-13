<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class TestSeeder extends Seeder
{
    /**
     * Run the test data seeds.
     *
     * @return void
     */
    public function run()
    {
        // _id, name, ruby, post, mail, api_token, password, telephone_number, secretary, stamp_groups, department_name, is_notification, notification_interval, is_admin, invitations, profile_image
        $members = [
            ['83b5603f-8436-4c93-189e-8387c15f823f', '橋本環奈', 'はしもとかんな', '女優', 'hashikann@discovery-n.co.jp', 'EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ', '$2y$10$MPEgFZgwoRLZ3idAD4Oo9uSO2kGWl33o4QOvVIPU5Cu8z2TXQBMvS'/* 19990203 */, '080-0000-0000', [], [], '東京笑門会', true, '1h', false, [], 'test01'],
            ['a08999b6-c1ff-a0e7-81cb-d04e2466b61d', '井手上漠', 'いでがみばく', 'モデル', 'baaaakuuuu@discovery-n.co.jp', 'uq5VaRjvWwAZ1yx8KiB4vdfdD31QXuVrMBpySn3XajnuzMkkhAKfD49WEBQp', '$2y$10$Pgtc5Lh7D6esT9NLzonfx.xuf1UXl8XWbFAF91NuRa6kwaQN7Olfe'/* 20030120 */, '080-0000-0001', ['name' => '井手上秘書男', 'mail' => 'bakuhisyo@discovery-n.co.jp'], [], '東京笑門会', false, '5h', false, [], 'test02'],
            ['8a488ce6-dbd0-3b66-4570-981dfe0b7641', '亜戸明', 'あどみん', '管理者', 'admin@admin.com', '9MjKUP0pkkwcCbFgxPWtO5TYXKJ1KoqB7vzVgg8PriwOtekpPrloqmPAssPQ', '$2y$10$b7CtSFHuH6Af8FFrNhqotuN.AT7fdMI.8T6byBkkDYenJ2zXI5qxG'/* hogehoge */, '070-0000-0000', [], [], '愛媛笑門会', true, '0.5h', true, [], 'test03']
        ];

        // _id, name, address, telephone_number, members
        $companies = [
            ['e6a91e70-bae6-08e0-8ee7-0a7f595f30fc', '株式会社 ディスカバリー･ネクスト', '東京都渋谷区神宮前6-23-2 第25SYビル4F', '03-6427-1408', ['83b5603f-8436-4c93-189e-8387c15f823f', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d']],
            ['67653c1a-6036-b2cd-0434-f1f21c024a86', '管理者コーポレーション', '愛媛県松山市今市', '089-0000-0000', ['8a488ce6-dbd0-3b66-4570-981dfe0b7641']],
            ['da192210-b876-0b59-1a96-095d2ef2dd11', '有限会社 テスト', '鎌倉の某所', '0467-0000-0000', []]
        ];

        // _id, is_group, is_department, group_name, admin_member_id, members, contents, chat_room_image
        $chatRooms = [
            ['feeee66d-695b-7eeb-78a5-7e373fcfce71', true, true, '愛媛笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [['_id' => '8a488ce6-dbd0-3b66-4570-981dfe0b7641', 'name' => '亜戸明']], [], 'testehime'],
            ['1e7e362e-531b-41a7-1ac1-2d13bd90673b', true, true, '鎌倉笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [['_id' => '8a488ce6-dbd0-3b66-4570-981dfe0b7641', 'name' => '亜戸明']], [], 'testkamakura'],
            ['367d0bee-ded1-46e5-f05d-5c9720b9a54e', true, true, '東京笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [['_id' => '8a488ce6-dbd0-3b66-4570-981dfe0b7641', 'name' => '亜戸明'], ['_id' => '83b5603f-8436-4c93-189e-8387c15f823f', 'name' => '橋本環奈'], ['_id' => 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d', 'name' => '井手上漠']], [], 'testtokyo'],
            ['18283bc6-0b2e-6aa7-e6b1-04a2ec773a46', true, true, '大阪笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [['_id' => '8a488ce6-dbd0-3b66-4570-981dfe0b7641', 'name' => '亜戸明']], [], 'testosaka']/*,
            ['6f7dd1ad-df0b-33e1-8ba8-5e229b34386f', false, false, null, '83b5603f-8436-4c93-189e-8387c15f823f', [['_id' => '83b5603f-8436-4c93-189e-8387c15f823f', 'name' => '橋本環奈'], ['_id' => 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d', 'name' => '井手上漠']], []],
            ['6597f39d-8676-c123-7a17-5a6858b3f55a', false, false, null, '83b5603f-8436-4c93-189e-8387c15f823f', [['_id' => '83b5603f-8436-4c93-189e-8387c15f823f', 'name' => '橋本環奈'], ['_id' => '8a488ce6-dbd0-3b66-4570-981dfe0b7641', 'name' => '亜戸明']], []]*/
        ];

        for ($i = 0; $i < count($members); $i++) {
            Member::create([
                '_id' => $members[$i][0],
                'name' => $members[$i][1],
                'ruby' => $members[$i][2],
                'post' => $members[$i][3],
                'mail' => $members[$i][4],
                'api_token' => $members[$i][5],
                'password' => $members[$i][6],
                'telephone_number' => $members[$i][7],
                'secretary' => $members[$i][8],
                'stamp_groups' => $members[$i][9],
                'department_name' => $members[$i][10],
                'is_notification' => $members[$i][11],
                'notification_interval' => $members[$i][12],
                'is_admin' => $members[$i][13],
                'invitations' => $members[$i][14]
            ]);
            Storage::putFileAs('private/images/profile_images/', new File('storage/app/images/test/' . $members[$i][15] . '.png'), $members[$i][0] . '.png', 'private');
        }

        for ($i = 0; $i < count($companies); $i++) {
            Company::create([
                '_id' => $companies[$i][0],
                'name' => $companies[$i][1],
                'address' => $companies[$i][2],
                'telephone_number' => $companies[$i][3],
                'members' => $companies[$i][4]
            ]);
        }

        for ($i = 0; $i < count($chatRooms); $i++) {
            ChatRoom::create([
                '_id' => $chatRooms[$i][0],
                'is_group' => $chatRooms[$i][1],
                'is_department' => $chatRooms[$i][2],
                'group_name' => $chatRooms[$i][3],
                'admin_member_id' => $chatRooms[$i][4],
                'members' => $chatRooms[$i][5],
                'contents' => $chatRooms[$i][6]
            ]);
            Storage::putFileAs('private/images/chats', new File('storage/app/images/test/' . $chatRooms[$i][7] . '.png'), $chatRooms[$i][0] . '.png', 'private');
        }
    }
}
