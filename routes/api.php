<?php

use AdriCeci\AuditCenter\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

$prefix = config('audit-center.routes.prefix', 'api/audit-logs');
$middleware = config('audit-center.routes.middleware', ['auth:sanctum', 'admin']);

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
