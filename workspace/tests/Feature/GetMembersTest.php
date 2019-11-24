<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;
use App\Models\Member;
use Tests\Feature\TestData;

/**t GET /api/members */
class GetMembersTest extends TestCase
{
    use RefreshDatabase;

    /** 認証されている状態でリクエストした場合、会員一覧情報が取得できること */
    public function testAuthenticated()
    {
        $testDataMembers = TestData::getMembers();
        $authMember = TestData::getRandMember($testDataMembers);

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . $authMember['api_token']])
            // 「/api/members」でGETでリクエストを送信
            ->getJson('/api/members');

        $members = [];
        foreach ($testDataMembers as $idx => $testDataMember) {
            $members[] = [
                '_id' => $testDataMember['_id'],
                'name' => $testDataMember['name'],
                'ruby' => $testDataMember['ruby'],
                'post' => $testDataMember['post'],
                'department_name' => $testDataMember['department_name']
            ];
        }

        $response
            // ステータスコードが200
            ->assertOk()
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'members' => $members
            ]);
    }

    /** 認証されていない状態でリクエストした場合に、会員一覧情報取得に失敗すること */
    public function testNotAuthenticated()
    {
        $response = $this
            // 「/api/members」でGETでリクエストを送信
            ->getJson('/api/members');

        $response
            // ステータスコードが401
            ->assertStatus(401)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => false,
                'result' => false,
                'message' => '認証エラー'
            ]);
    }
}
