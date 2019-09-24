<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompaniesSeeder::class);
        $this->call(StampGroupSeeder::class);
        $this->call(MembersSeeder::class);
        $this->call(InvitationSeeder::class);
        $this->call(ForumSeeder::class);
        $this->call(ChatRoomSeeder::class);
    }
}
