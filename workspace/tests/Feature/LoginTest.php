<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;

/**t POST /login */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** 存在するnameとpasswordの組を送信した場合、認証が成功すること */
    public function testExist()
    {
        $response = $this
            // 任意の会員のnameとpasswordで「/login」にPOSTでリクエストを送信
            ->postJson('/login', ['name' => '橋本環奈', 'password' => '19990203']);

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
                    'is_admin' => false
                ]
            ]);
    }

    /** 存在しないnameとpasswordの組を送信した場合、ログインページにリダイレクトされること */
    public function testNotExist()
    {

    }
}
