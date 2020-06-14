<?php


namespace Tests;


trait RefreshDatabaseWithViews
{
    protected function migrateFreshWithViews(): void
    {
        $this->artisan('migrate:fresh --drop-views');
    }
}
