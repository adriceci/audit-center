<?php

namespace AdriCeci\AuditCenter\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AuditCenterServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     */
    public function register(): void
    {
        // Merge the package configuration with the application's published configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/audit-center.php',
            'audit-center'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        // Publish configuration file
        $this->publishes([
            __DIR__ . '/../../config/audit-center.php' => config_path('audit-center.php'),
        ], 'audit-center-config');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'audit-center-migrations');

        // Publish Vue source files
        $this->publishes([
            __DIR__ . '/../../resources/js' => resource_path('js/vendor/audit-center'),
        ], 'audit-center-vue-source');

        // Register routes
        $this->registerRoutes();

        // Auto-register middleware if configured
        if (config('audit-center.middleware.auto_register', false)) {
            $this->registerMiddleware();
        }
    }

    /**
     * Register package routes.
     */
    protected function registerRoutes(): void
    {
        Route::group([
            'prefix' => 'api',
            'namespace' => 'AdriCeci\AuditCenter\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        });
    }

    /**
     * Register the audit logging middleware.
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        // Get the middleware alias or class name
        $middleware = \AdriCeci\AuditCenter\Http\Middleware\AuditLogMiddleware::class;

        // Register middleware alias
        $router->aliasMiddleware('audit.log', $middleware);

        // Optionally append to API middleware group
        if (method_exists($router, 'middlewareGroup')) {
            $router->pushMiddlewareToGroup('api', $middleware);
        } else {
            // For Laravel 11+ bootstrap/app.php approach
            // Middleware registration happens in the consuming app's bootstrap/app.php
            // This is just for backwards compatibility
        }
    }
}
