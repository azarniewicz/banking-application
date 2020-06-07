<?php


namespace Tests;


trait SeedDatabase
{
    protected function seedDatabase(): void
    {
        $this->artisan('db:seed');
    }
}
