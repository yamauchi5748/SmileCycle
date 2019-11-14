<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;
use Tests\Feature\TestData;

/**t GET /api/members/{member_id} */
class GetMemberTest extends TestCase
{
    use RefreshDatabase;

    /** 認証されている状態でリクエストした場合、会員詳細情報が取得できること */
    public function testAuthenticated()
    {
        $testDataMembers = TestData::MEMBERS;
        $generalMembers = TestData::getGeneralMembers($testDataMembers);
        $member = $generalMembers[1];

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($generalMembers[0], 'api_token')])
            // 「/api/members/{任意の会員のmembers._id}」でGETでリクエストを送信
            ->getJson('/api/members/' . TestData::getMemberField($member, '_id'));
        
        $testDataCompanies = TestData::COMPANIES;
        $company = TestData::getCompanyWithMemberId($testDataCompanies, TestData::getMemberField($member, '_id'));

        $response
            // ステータスコードが200
            ->assertOk()
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'member' => [
                    '_id' => TestData::getMemberField($member, '_id'),
                    'name' => TestData::getMemberField($member, 'name'),
                    'ruby' => TestData::getMemberField($member, 'ruby'),
                    'post' => TestData::getMemberField($member, 'post'),
                    'telephone_number' => TestData::getMemberField($member, 'telephone_number'),
                    'mail' => TestData::getMemberField($member, 'mail'),
                    'department_name' => TestData::getMemberField($member, 'department_name'),
                    'company_id' => TestData::getCompanyField($company, '_id'),
                    'company_name' => TestData::getCompanyField($company, 'name'),
                    'secretary' => TestData::getMemberField($member, 'secretary')
                ]
            ]);
    }

    /** 認証されていない状態でリクエストした場合、会員詳細情報取得に失敗すること */
    public function testNotAuthenticated()
    {
        $testDataMembers = TestData::MEMBERS;

        $response = $this
            // 「/api/members/{任意の会員のmembers._id}」でGETでリクエストを送信
            ->getJson('/api/members/' . TestData::getMemberField($testDataMembers[1], '_id'));

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

    /** member_idに存在しないmembers._idが指定された場合、バリデーションエラーが返されること */
    public function testNotExist()
    {
        $testDataMembers = TestData::MEMBERS;

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($testDataMembers[0], 'api_token')])
            // 「/api/members/{members._idに存在しないuuid}」でGETでリクエストを送信
            ->getJson('/api/members/f6eae376-502b-4aca-0829-5cacfa397df4');

        $response
            // ステータスコードが422
            ->assertStatus(422)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => false,
                'message' => [
                    'member_id' => ['27']
                ]
            ]);
    }

    /** member_idにuuidの形式でない値が指定された場合、バリデーションエラーが返されること */
    public function testNotUUID()
    {
        $testDataMembers = TestData::MEMBERS;

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($testDataMembers[0], 'api_token')])
            // 「/api/members/{uuidでない任意の文字列}」でGETでリクエストを送信
            ->getJson('/api/members/hogee');

        $response
            // ステータスコードが422
            ->assertStatus(422)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => false,
                'message' => [
                    'member_id' => ['87']
                ]
            ]);
    }
}
