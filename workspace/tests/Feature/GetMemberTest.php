<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\RefreshDatabase;

/**t GET /api/members/{member_id} */
class GetMemberTest extends TestCase
{
    /** 認証されている状態でリクエストした場合、会員詳細情報が取得できること */
    public function testAuthenticated()
    {
    }

    /** 認証されていない状態でリクエストした場合、会員詳細情報取得に失敗すること */
    public function testNotAuthenticated()
    {

    }

    /** member_idに存在しないmembers._idが指定された場合、バリデーションエラーが返されること */
    public function testNotExist()
    {

    }

    /** member_idにuuidの形式でない値が指定された場合、バリデーションエラーが返されること */
    public function testNotUUID()
    {

    }
}
