<?php

namespace ClaudiusNascimento\XACL;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class XACLServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'xacl');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'xacl');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');

        $this->registerHelpers();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/xacl.php' => config_path('xacl.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/xacl'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/xacl'),
            ], 'assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/xacl'),
            ], 'lang');

            // Registering package commands.
            // $this->commands([]);
        }

        $this->configBladeDirectives();
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        // Load the helpers in app/Http/helpers.php
        if (file_exists($helper = __DIR__ . '/helpers.php'))
        {
            require $helper;
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/xacl.php', 'xacl');

        // Register the main class to use with the facade
        $this->app->singleton('xacl', function () {
            return new XACL;
        });
    }

    private function configBladeDirectives()
    {

        $xaclCan = config('xacl.blade.can_open_tag', 'xaclCanSee');
        $endXaclCan = config('xacl.blade.can_close_tag', 'endXaclCanSee');
        $xaclCanNot = config('xacl.blade.can_not_open_tag', 'xaclCanNotSee');
        $endXaclCanNot = config('xacl.blade.can_not_close_tag', 'endXaclCanNotSee');

        Blade::directive($xaclCan, function ($action) {
            return "<?php if (xaclCanSee({$action})): ?>";
        });

        Blade::directive($endXaclCan, function ($action) {
            return "<?php endif; ?>";
        });

        Blade::directive($xaclCanNot, function ($action) {
            return "<?php if (xaclCanNot({$action})): ?>";
        });

        Blade::directive($endXaclCanNot, function ($action) {
            return "<?php endif; ?>";
        });
    }
}
