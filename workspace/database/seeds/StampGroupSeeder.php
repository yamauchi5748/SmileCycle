<?php

use Illuminate\Database\Seeder;

class StampGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\StampGroup::class, 30)->create();
    }
}
