<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Company;
use App\Models\ChatRoom;
use App\Models\StampGroup;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\TestData;

/**t Post /api/members */
class PostMemberTest extends TestCase
{
    use RefreshDatabase;

    /** 全項目に正しい値を入力してリクエストした場合、会員の登録が行えること */
    public function testAllParameter()
    {
        $testDataMembers = TestData::getMembers();
        $authAdminMember = TestData::getRandAdminMember($testDataMembers);
        $useCompany = TestData::getRandCompany(TestData::getCompanies());
        $testDataStampGroups = TestData::getStampGroups();
        $postMember = [
            'name' => '新田真剣佑', 'ruby' => 'あらたまっけんゆう', 'post' => '俳優', 'telephone_number' => '080-9999-9999', 'company_id' => $useCompany['_id'], 'department_name' => '鎌倉笑門会', 'mail' => 'makken@test.co.jp', 'secretary_name' => '綿谷新', 'secretary_mail' => 'wataya@test.co.jp', 'password' => 'Makken96', 'password_confirmation' => 'Makken96'
        ];

        $response = $this
            // 任意の管理者で認証
            ->withHeaders(['Authorization' => 'Bearer ' . $authAdminMember['api_token']])
            // 「/api/members」（すべてのパラメータに正しい範囲の任意の値を入力）でPOSTでリクエストを送信
            ->postJson('/api/members', $postMember);

        $createMember = Member::where('name', '=', $postMember['name'])->get()->first();
        $companies = Company::whereIn('members', [$createMember['_id']])->get();
        $departmentChatRooms = ChatRoom::where('is_department', '=', 1)->whereIn('members.name', [$postMember['name']])->get();
        $personalChatRooms = ChatRoom::where('is_group', '=', 0)->whereIn('members.name', [$postMember['name']])->get();
        $stampGroupsAreAll = StampGroup::where('is_all', '=', 1)->get();

        // membersに会員情報が追加されている
        $this->assertDatabaseHas('members', ['name' => $postMember['name'], 'ruby' => $postMember['ruby'], 'post' => $postMember['post'], 'telephone_number' => $postMember['telephone_number'], 'department_name' => $postMember['department_name'], 'mail' => $postMember['mail'], 'secretary' => ['name' => $postMember['secretary_name'], 'mail' => $postMember['secretary_mail']]]);
        $this->assertTrue(Hash::check($postMember['password'], $createMember['password']), 'members.passwordに正しいハッシュ値が挿入されていない');

        // 指定したcompanies._idのcompanies.membersだけに、登録した会員の_idが追加されている
        $this->assertCount(1, $companies);  // 0なら指定した会社に追加されていない。（2以上なら指定した会社以外に追加されている）
        $this->assertEquals($postMember['company_id'], $companies[0]['_id']);  // 違ったら別の会社に追加されている

        // プロフィール画像が保存されている
        Storage::disk('local')->assertExists('/private/images/profile_images/' . $createMember['_id'] . '.png');

        // 指定した部門のchat_room.membersにmembers._idが追加されている
        $this->assertCount(1, $departmentChatRooms);
        $this->assertEquals($postMember['department_name'], $departmentChatRooms[0]['group_name']);
        // 全会員との個人チャットが追加されている
        $this->assertCount(count($testDataMembers), $personalChatRooms);
        $membersId = array_column($testDataMembers, '_id');
        foreach ($personalChatRooms as $personalChatRoom) {
            $this->assertCount(2, $personalChatRoom['members'], 'chat_roomが正しく作成されていない');
            $id = $personalChatRoom['members'][1 - array_search($createMember['_id'], $personalChatRoom['members'])]['_id'];
            $foundIdx = array_search($id, $membersId);
            $this->assertTrue($foundIdx !== FALSE, 'chat_roomが正しく作成されていない');
            array_splice($membersId, $foundIdx, 1);
        }

        // is_all が 1 の stamp_groups._id が members.stamp_groups に追加されている
        $alls = TestData::getStampGroupsAreAll($testDataStampGroups);
        $this->assertCount(count($alls), $createMember['stamp_groups']);
        $allsId = array_column($alls, '_id');
        foreach ($createMember['stamp_groups'] as $stampGroup) {
            $foundIdx = array_search($stampGroup, $allsId);
            $this->assertTrue($foundIdx !== FALSE, 'members.stamp_groupsが正しく作成されていない');
            array_splice($allsId, $foundIdx, 1);
        }

        // is_all が 1 の stamp_groups.members に members._id が追加されている
        foreach ($stampGroupsAreAll as $stampGroupIsAll) {
            $this->assertContains($createMember['_id'], $stampGroupIsAll['members'], 'is_allが1のstamp_groups.membersにmembers._idが追加されていない');
        }

        $response
            // ステータスコードが200
            ->assertOk()
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'member' => [
                    '_id' => $createMember['_id'],
                    'name' => $postMember['name'],
                    'ruby' => $postMember['ruby'],
                    'post' => $postMember['post'],
                    'telephone_number' => $postMember['telephone_number'],
                    'mail' => $postMember['mail'],
                    'department_name' => $postMember['department_name'],
                    'secretary' => [
                        'name' => $postMember['secretary_name'],
                        'mail' => $postMember['secretary_mail']
                    ],
                    'company_id' => $postMember['company_id'],
                    'company_name' => $useCompany['name']
                ]
            ]);
    }
}
