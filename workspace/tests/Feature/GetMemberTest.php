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
        $authMember = TestData::getRandMember($testDataMembers);
        $targetMember = TestData::getRandMember($testDataMembers);

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($authMember, 'api_token')])
            // 「/api/members/{任意の会員のmembers._id}」でGETでリクエストを送信
            ->getJson('/api/members/' . TestData::getMemberField($targetMember, '_id'));
        
        $testDataCompanies = TestData::COMPANIES;
        $company = TestData::getCompanyWithMemberId($testDataCompanies, TestData::getMemberField($targetMember, '_id'));

        $response
            // ステータスコードが200
            ->assertOk()
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'member' => [
                    '_id' => TestData::getMemberField($targetMember, '_id'),
                    'name' => TestData::getMemberField($targetMember, 'name'),
                    'ruby' => TestData::getMemberField($targetMember, 'ruby'),
                    'post' => TestData::getMemberField($targetMember, 'post'),
                    'telephone_number' => TestData::getMemberField($targetMember, 'telephone_number'),
                    'mail' => TestData::getMemberField($targetMember, 'mail'),
                    'department_name' => TestData::getMemberField($targetMember, 'department_name'),
                    'company_id' => TestData::getCompanyField($company, '_id'),
                    'company_name' => TestData::getCompanyField($company, 'name'),
                    'secretary' => TestData::getMemberField($targetMember, 'secretary')
                ]
            ]);
    }

    /** 認証されていない状態でリクエストした場合、会員詳細情報取得に失敗すること */
    public function testNotAuthenticated()
    {
        $targetMember = TestData::getRandMember(TestData::MEMBERS);

        $response = $this
            // 「/api/members/{任意の会員のmembers._id}」でGETでリクエストを送信
            ->getJson('/api/members/' . TestData::getMemberField($targetMember, '_id'));

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
        $authMember = TestData::getRandMember($testDataMembers);

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($authMember, 'api_token')])
            // 「/api/members/{members._idに存在しないuuid}」でGETでリクエストを送信
            ->getJson('/api/members/' . TestData::noDuplicateMemberUuid($testDataMembers));

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
        $authMember = TestData::getRandMember(TestData::MEMBERS);

        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer ' . TestData::getMemberField($authMember, 'api_token')])
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
