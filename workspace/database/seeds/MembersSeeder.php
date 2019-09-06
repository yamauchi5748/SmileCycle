<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class MembersSeeder extends Seeder
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
        $company_id = $faker->randomElement(Company::select()->get())->_id;
        $company = Company::where('_id', $company_id)->first();

        $members = $company->members;
        array_push($members, $_id);
        $company->members = $members;
        $company->save();

        // プロフィール画像のパス名をランダムに取得
        $path_name = $faker->randomElement(['boy_1', 'boy_2', 'boy_3']);

        // 管理者のプロフィール画像をストレージに保存
        Storage::putFileAs('public/images', new File('storage/app/images/' . $path_name . '.png'), $_id . '.png', 'public');
    
        Member::raw()->insertOne([
            '_id' => $_id,
            'api_token' => Str::random(60),
            'is_notification' => true,
            'notification_interval' => '0.5h',
            'is_admin' => true,
            'name' => 'admin',
            'ruby' => 'あどみん',
            'post' => '管理者',
            'telephone_number' => $faker->phoneNumber,
            'department_name' => $faker->randomElement(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会']),
            'stamp_groups' => [(string) Str::uuid(), (string) Str::uuid()],
            'mail' => $faker->safeEmail,
            'password' => Hash::make('admin')
        ]);
        factory(App\Models\Member::class, 100)->create();
    }
}
