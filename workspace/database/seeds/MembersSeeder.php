<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;
use App\Models\StampGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Member::class, 100)->create();
    }
}
