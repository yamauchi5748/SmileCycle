<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;

class TestSeeder extends Seeder
{
    /**
     * Run the test data seeds.
     *
     * @return void
     */
    public function run()
    {
        // _id, name, ruby, post, mail, api_token, password, telephone_number, secretary, stamp_groups, department_name, is_notification, notification_interval, is_admin, invitations
        $members = [
            ['83b5603f-8436-4c93-189e-8387c15f823f', '橋本環奈', 'はしもとかんな', '女優', 'hashikann@discovery-n.co.jp', 'EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ', '$2y$10$MPEgFZgwoRLZ3idAD4Oo9uSO2kGWl33o4QOvVIPU5Cu8z2TXQBMvS'/* 19990203 */, '080-0000-0000', [], [], '東京笑門会', true, '1h', false, []],
            ['a08999b6-c1ff-a0e7-81cb-d04e2466b61d', '井手上漠', 'いでがみばく', 'モデル', 'baaaakuuuu@discovery-n.co.jp', 'uq5VaRjvWwAZ1yx8KiB4vdfdD31QXuVrMBpySn3XajnuzMkkhAKfD49WEBQp', '$2y$10$Pgtc5Lh7D6esT9NLzonfx.xuf1UXl8XWbFAF91NuRa6kwaQN7Olfe'/* 20030120 */, '080-0000-0001', [], [], '東京笑門会', false, '5h', false, []]
        ];

        // _id, name, address, telephone_number, members
        $companies = [
            ['e6a91e70-bae6-08e0-8ee7-0a7f595f30fc', '株式会社 ディスカバリー･ネクスト', '東京都渋谷区神宮前6-23-2 第25SYビル4F', '03-6427-1408', ['83b5603f-8436-4c93-189e-8387c15f823f', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d']]
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
    }
}
