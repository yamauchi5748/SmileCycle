<?php

namespace Tests\Feature\Http\Controllers\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MemberControllerTest extends TestCase
{
    // データベースの初期化にトランザクションを使う
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $this->testIndex();
    }

    public function testIndex()
    {
        // 検証(assert) をココに書く

        // GET リクエスト
        $response = $this->get(route('members.index'));

        // レスポンスの検証
        $response->assertOk()  # ステータスコードが 200
            ->assertJsonCount(1) # レスポンスの配列の件数が1件
            ->assertJsonFragment([ # レスポンスJSON に以下の値を含む
                'mail' => 'user1@example.com',
            ]);
    }
}
