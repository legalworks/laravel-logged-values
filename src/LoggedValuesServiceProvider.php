<?php

namespace Legalworks\LoggedValues;

use Illuminate\Support\ServiceProvider;

class LoggedValuesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'legalworks');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'legalworks');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/logged-values.php', 'logged-values');

        // Register the service the package provides.
        $this->app->singleton('logged-values', function ($app) {
            return new LoggedValues;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['logged-values'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        if (!class_exists('CreateLoggedValuesTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/2020_10_27_000000_create_logged_values_table' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_logged_values_table.php'),
            ], 'migrations');
        }

        $this->publishes([
            __DIR__ . '/../config/logged-values.php' => config_path('logged-values.php'),
        ], 'logged-values.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/legalworks'),
        ], 'laravel-logged-values.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/legalworks'),
        ], 'laravel-logged-values.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/legalworks'),
        ], 'laravel-logged-values.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
