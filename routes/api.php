<?php

use AdriCeci\AuditCenter\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

// Get prefix from config, remove 'api/' if present since ServiceProvider adds it
$prefix = config('audit-center.routes.prefix', 'api/audit-logs');
// Remove 'api/' prefix if it exists, since ServiceProvider already adds it
$prefix = preg_replace('/^api\//', '', $prefix);
$middleware = config('audit-center.routes.middleware', ['auth:sanctum', 'admin']);

// Public config endpoint (no auth required - only returns route configuration)
Route::prefix($prefix)
    ->group(function () {
        Route::get('/config', [AuditLogController::class, 'config'])->name('audit-logs.config');
    });

// Protected routes (require admin)
Route::prefix($prefix)
    ->middleware($middleware)
    ->group(function () {
        Route::get('/', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/stats', [AuditLogController::class, 'stats'])->name('audit-logs.stats');
        Route::get('/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
        Route::post('/', [AuditLogController::class, 'store'])->name('audit-logs.store');
        Route::put('/{auditLog}', [AuditLogController::class, 'update'])->name('audit-logs.update');
        Route::patch('/{auditLog}', [AuditLogController::class, 'update'])->name('audit-logs.patch');
        Route::delete('/{auditLog}', [AuditLogController::class, 'destroy'])->name('audit-logs.destroy');
    });
