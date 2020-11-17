<?php

namespace Legalworks\LoggedValues\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\ValidationRules\ValidationRulesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;


abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        // $this->app->make(EloquentFactory::class)->load(__DIR__ . '/factories');
    }

    protected function getPackageProviders($app)
    {
        return [
            ValidationRulesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        include_once __DIR__ . '/../database/migrations/create_logged_values_table.php.stub';

        (new \CreateLoggedValuesTable)->up();
    }
}
