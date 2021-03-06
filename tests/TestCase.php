<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->withoutExceptionHandling();
    }

}
