<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;

use App\Models\Member;

/**t GET / */
class HomeTest extends TestCase
{
    use RefreshDatabase;

    /** 任意の会員でログインしている場合、ホームページが返されること */
    public function testLoggedIn()
    {
        $member = Member::find(['_id' => '83b5603f-8436-4c93-189e-8387c15f823f']);
        
        $response = $this
            // 任意の会員でログイン
            ->actingAs($member[0])
            // 「/」でGETでリクエストを送信
            ->getJson('/');

        $response
            // ステータスコードが200
            ->assertStatus(200)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => true,
                'profile' => [
                    'name' => '橋本環奈',
                    'ruby' => 'はしもとかんな',
                    'post' => '女優',
                    'mail' => 'hashikann@discovery-n.co.jp',
                    'company_id' => 'e6a91e70-bae6-08e0-8ee7-0a7f595f30fc',
                    'department_name' => '東京笑門会',
                    'id_admin' => false
                ]
            ]);
    }

    /** ログインしていない場合、認証エラーが返されること */
    public function testNotLoggedIn ()
    {
        $response = $this
            // 「/」でGETでリクエストを送信
            ->getJson('/');

        $response
            // ステータスコードが401
            ->assertStatus(401)
            // レスポンスデータが下記の通り
            ->assertExactJson([
                'auth' => false,
                'result' => false,
                'message'=> '認証エラー'
            ]);
    }
}
