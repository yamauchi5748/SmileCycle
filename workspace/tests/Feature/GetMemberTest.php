<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;

/**t GET /api/members/{member_id} */
class GetMemberTest extends TestCase
{
    use RefreshDatabase;

    /** 認証されている状態でリクエストした場合、会員詳細情報が取得できること */
    public function testAuthenticated()
    {
        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ'])
            // 「/api/members/{任意の会員のmembers._id}」でGETでリクエストを送信
            ->getJson('/api/members/a08999b6-c1ff-a0e7-81cb-d04e2466b61d');
        
        $response
            // ステータスコードが200
            ->assertStatus(200)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'member' => [
                    '_id' => 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d',
                    'name' => '井手上漠',
                    'ruby' => 'いでがみばく',
                    'post' => 'モデル',
                    'telephone_number' => '080-0000-0001',
                    'mail' => 'baaaakuuuu@discovery-n.co.jp',
                    'department_name' => '東京笑門会',
                    'company_id' => 'e6a91e70-bae6-08e0-8ee7-0a7f595f30fc',
                    'company_name' => '株式会社 ディスカバリー･ネクスト',
                    'secretary' => [
                        'name' => '井手上秘書男',
                        'mail' => 'bakuhisyo@discovery-n.co.jp'
                    ]
                ]
            ]);
    }

    /** 認証されていない状態でリクエストした場合、会員詳細情報取得に失敗すること */
    public function testNotAuthenticated()
    {
        $response = $this
            // 「/api/members/{任意の会員のmembers._id}」でGETでリクエストを送信
            ->getJson('/api/members/a08999b6-c1ff-a0e7-81cb-d04e2466b61d');

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
        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ'])
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
        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ'])
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
