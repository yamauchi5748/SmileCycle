<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

/** 自作のRefreshDatabaseトレイト */
trait RefreshDatabase
{
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function refreshDatabase()
    {
        $this->refreshTestDatabase();
    }

    /**
     * Refresh a test database.
     *
     * @return void
     */
    public function refreshTestDatabase()
    {
        $this->artisan('db:wipe');
        $this->app[Kernel::class]->setArtisan(null);

        $this->artisan('db:seed', ['--class' => 'TestSeeder']);
        $this->app[Kernel::class]->setArtisan(null);
    }
}