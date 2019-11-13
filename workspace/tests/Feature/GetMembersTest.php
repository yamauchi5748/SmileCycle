<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;
use App\Models\Member;

/**t GET /api/members */
class GetMembersTest extends TestCase
{
    use RefreshDatabase;

    /** 認証されている状態でリクエストした場合、会員一覧情報が取得できること */
    public function testAuthenticated()
    {
        $response = $this
            // 任意の会員で認証
            ->withHeaders(['Authorization' => 'Bearer EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ'])
            // 「/api/members」でGETでリクエストを送信
            ->getJson('/api/members');

        $response
            // ステータスコードが200
            ->assertStatus(200)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'result' => true,
                'members' => [
                    [
                        '_id' => '83b5603f-8436-4c93-189e-8387c15f823f',
                        'name' => '橋本環奈',
                        'ruby' => 'はしもとかんな',
                        'post' => '女優',
                        'department_name' => '東京笑門会'
                    ],
                    [
                        '_id' => 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d',
                        'name' => '井手上漠',
                        'ruby' => 'いでがみばく',
                        'post' => 'モデル',
                        'department_name' => '東京笑門会'
                    ],
                    [
                        '_id' => '8a488ce6-dbd0-3b66-4570-981dfe0b7641',
                        'name' => '亜戸明',
                        'ruby' => 'あどみん',
                        'post' => '管理者',
                        'department_name' => '愛媛笑門会'
                    ]
                ]
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
