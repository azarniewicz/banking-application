<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getNewUuid()
    {
        return Str::uuid()->toString();
    }

    /**
     * Boot the testing helper traits.
     *
     * @return void
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();
        if (isset($uses[SeedDatabase::class])) {
            $this->seedDatabase();
        }
    }

}
