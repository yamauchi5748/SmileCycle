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
        $testDataMembers = TestData::MEMBERS;
        $authAdminMember = TestData::getRandAdminMember($testDataMembers);

        $response = $this
            // 任意の管理者で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($authAdminMember, 'api_token')])
            // 「/api/members」（すべてのパラメータに正しい範囲の任意の値を入力）でPOSTでリクエストを送信
            ->postJson('/api/members', ['name' => '新田真剣佑', 'ruby' => 'あらたまっけんゆう', 'post' => '俳優', 'telephone_number' => '080-9999-9999', 'company_id' => 'da192210-b876-0b59-1a96-095d2ef2dd11', 'department_name' => '鎌倉笑門会', 'mail' => 'makken@test.co.jp', 'secretary_name' => '綿谷新', 'secretary_mail' => 'wataya@test.co.jp', 'password' => 'Makken96', 'password_confirmation' => 'Makken96']);

        $createMember = Member::where('name', '=', '新田真剣佑')->get()->first();
        $companies = Company::whereIn('members', [$createMember['_id']])->get();
        $departmentChatRooms = ChatRoom::where('is_department', '=', true)->whereIn('members.name', ['新田真剣佑'])->get();
        $personalChatRooms = ChatRoom::where('is_group', '=', false)->whereIn('members.name', ['新田真剣佑'])->get();
        $testDataStampGroups = TestData::STAMP_GROUPS;

        // membersに会員情報が追加されている
        $this->assertDatabaseHas('members', ['name' => '新田真剣佑', 'ruby' => 'あらたまっけんゆう', 'post' => '俳優', 'telephone_number' => '080-9999-9999', 'department_name' => '鎌倉笑門会', 'mail' => 'makken@test.co.jp', 'secretary' => ['name' => '綿谷新', 'mail' => 'wataya@test.co.jp']]);
        $this->assertTrue(Hash::check('Makken96', $createMember['password']), 'members.passwordに正しいハッシュ値が挿入されていない');

        // 指定したcompanies._idのcompanies.membersだけに、登録した会員の_idが追加されている
        $this->assertCount(1, $companies);  // 0なら指定した会社に追加されていない。（2以上なら指定した会社以外に追加されている）
        $this->assertEquals('da192210-b876-0b59-1a96-095d2ef2dd11', $companies[0]['_id']);  // 違ったら別の会社に追加されている

        // プロフィール画像が保存されている
        Storage::disk('local')->assertExists('/private/images/profile_images/' . $createMember['_id'] . '.png');

        // 指定した部門のchat_room.membersにmembers._idが追加されている
        $this->assertCount(1, $departmentChatRooms);
        $this->assertEquals('鎌倉笑門会', $departmentChatRooms[0]['group_name']);
        // 全会員との個人チャットが追加されている
        $this->assertCount(count($testDataMembers), $personalChatRooms);
        foreach ($personalChatRooms as $personalChatRoom) {
            $this->assertCount(2, $personalChatRoom['members'], 'chat_roomが正しく作成されていない');
            $id = $personalChatRoom['members'][1 - array_search($createMember['_id'])];
            $foundIdx = -1;
            foreach ($testDataMembers as $idx => $member) {
                if (strcmp($id, TestData::getMemberField($member, '_id')) === 0) {
                    $foundIdx = $idx;
                    break;
                }
            }
            $this->assertTrue($foundIdx !== -1, 'chat_roomが正しく作成されていない');
            array_splice($testDataMembers, $foundIdx, 1);
            dump($testDataMembers);
            dump(TestData::MEMBERS);
        }

        // stampgroup isall が追加されている
        $alls = TestData::getStampGroupsAreAll($testDataStampGroups);
        echo 'hoge';

        $response
            // ステータスコードが200
            ->assertOk()
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'member' => [
                    '_id' => $member['_id'],
                    'name' => '新田真剣佑',
                    'ruby' => 'あらたまっけんゆう',
                    'post' => '俳優',
                    'telephone_number' => '080-9999-9999',
                    'mail' => 'makken@test.co.jp',
                    'department_name' => '鎌倉笑門会',
                    'secretary' => [
                        'name' => '綿谷新',
                        'mail' => 'wataya@test.co.jp'
                    ],
                    'company_id' => 'da192210-b876-0b59-1a96-095d2ef2dd11',
                    'company_name' => '有限会社 テスト'
                ]
            ]);
    }
}
