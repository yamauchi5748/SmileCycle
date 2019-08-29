<?php

use Illuminate\Database\Seeder;
use App\Member;
use App\Company;

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
        Member::create([
            'id' => (string) Str::uuid(),
            'api_token' => Str::random(60),
            'is_notification' => true,
            'notification_interval' => '0.5h',
            'is_admin' => true,
            'name' => 'admin',
            'ruby' => 'あどみん',
            'post' => '管理者',
            'tel' => $faker->phoneNumber,
            'company_id' => $faker->randomElement(Company::select('id')->get()),
            'department_name' => $faker->randomElement(['東京笑門会', '鎌倉笑門会', '大阪笑門会', '愛媛笑門会']),
            'mail' => $faker->safeEmail,
            'password' => Hash::make('admin')
        ]);
        factory(App\Member::class, 100)->create();
    }
}
