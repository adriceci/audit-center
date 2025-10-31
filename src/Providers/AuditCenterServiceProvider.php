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
     * 
     * Note: In Laravel 11+, middleware must be registered manually in bootstrap/app.php
     * using the withMiddleware() method. This method only registers an alias for
     * backwards compatibility with Laravel 10 and earlier.
     */
    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        // Get the middleware alias or class name
        $middleware = \AdriCeci\AuditCenter\Http\Middleware\AuditLogMiddleware::class;

        // Register middleware alias (for Laravel 10 and earlier compatibility)
        if (method_exists($router, 'aliasMiddleware')) {
            $router->aliasMiddleware('audit.log', $middleware);
        }

        // For Laravel 11+, middleware must be registered in bootstrap/app.php:
        // use AdriCeci\AuditCenter\Http\Middleware\AuditLogMiddleware;
        // $middleware->api(append: [AuditLogMiddleware::class]);
        
        // Attempt to register for Laravel 10 and earlier
        if (method_exists($router, 'pushMiddlewareToGroup')) {
            $router->pushMiddlewareToGroup('api', $middleware);
        }
        
        // Log a warning if auto-register is enabled but we're on Laravel 11+
        $laravelVersion = $this->app->version();
        if (version_compare($laravelVersion, '11.0.0', '>=')) {
            \Illuminate\Support\Facades\Log::warning(
                'Audit Center: auto_register middleware is not supported in Laravel 11+. ' .
                'Please register AuditLogMiddleware manually in bootstrap/app.php'
            );
        }
    }
}
