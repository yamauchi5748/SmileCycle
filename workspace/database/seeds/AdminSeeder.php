<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;
use App\Models\StampGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('ja_JP');

        $_id = (string) Str::uuid();
        $_id2 = (string) Str::uuid();

        /*会社データと紐づけ */
        $company_id = $faker->randomElement(Company::select()->get())->_id;
        $company = Company::where('_id', $company_id)->first();

        $members = $company->members;
        array_push($members, $_id);
        array_push($members, $_id2);
        $company->members = $members;
        $company->save();

        /* スタンプグループデータと紐づけ */
        $stamp_groups_obj = StampGroup::get();
        $stamp_groups_id = [];

        // スタンプグループにmemberを追加
        foreach ($stamp_groups_obj as $stamp_group) {
            $stamp_group_members = $stamp_group->members;
            array_push($stamp_group_members, $_id);
            array_push($stamp_group_members, $_id2);
            $stamp_group->members = $stamp_group_members;
            $stamp_group->save();
        }

        // スタンプグループの_idのみ配列に格納
        foreach ($stamp_groups_obj as $stamp_group) {
            $stamp_groups_id[] = $stamp_group->_id;
        }

        // プロフィール画像のパス名をランダムに取得
        $path_name = $faker->randomElement(['profile', 'profile_purple', 'profile_blue', 'profile_green']);

        // 管理者のプロフィール画像をストレージに保存
        Storage::putFileAs('private/images/profile_images/', new File('storage/app/images/' . $path_name . '.png'), $_id . '.png', 'private');
        Storage::putFileAs('private/images/profile_images/', new File('storage/app/images/' . $path_name . '.png'), $_id2 . '.png', 'private');

        Member::create([
            '_id' => $_id,
            'api_token' => Str::random(60),
            'is_notification' => 1,
            'notification_interval' => '0.5h',
            'is_admin' => 1,
            'name' => 'admin',
            'ruby' => 'あどみん',
            'post' => '管理者',
            'telephone_number' => $faker->phoneNumber,
            'department_name' => $faker->randomElement(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会']),
            'stamp_groups' => $stamp_groups_id,
            'mail' => $faker->safeEmail,
            'password' => Hash::make('admin')
        ]);

        Member::create([
            '_id' => $_id2,
            'api_token' => Str::random(60),
            'is_notification' => 1,
            'notification_interval' => '0.5h',
            'is_admin' => 1,
            'name' => 'admin2',
            'ruby' => 'あどみん2',
            'post' => '管理者',
            'telephone_number' => $faker->phoneNumber,
            'department_name' => $faker->randomElement(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会']),
            'stamp_groups' => $stamp_groups_id,
            'mail' => $faker->safeEmail,
            'password' => Hash::make('admin2')
        ]);
    }
}
