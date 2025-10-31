# Audit Center

A comprehensive Laravel package for audit logging with Vue.js frontend components.

## Features

- 🎯 Automatic audit logging for API requests
- 📊 Comprehensive audit log management
- 📈 Statistics and analytics dashboard
- 🎨 Beautiful Vue.js frontend components
- ⚙️ Highly configurable
- 🔒 Secure by default (sensitive fields excluded)
- 📱 Responsive design with dark mode support

## Installation

You can install the package via Composer:

```bash
composer require adriceci/audit-center
```

Or add it manually to your `composer.json`:

```json
{
  "require": {
    "adriceci/audit-center": "^1.0"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/adriceci/audit-center"
    }
  ]
}
```

## Configuration

### Publishing Configuration and Migrations

```bash
php artisan vendor:publish --provider="AdriCeci\AuditCenter\Providers\AuditCenterServiceProvider"
```

This will publish:

- `config/audit-center.php` - Package configuration
- Database migrations to `database/migrations/`

### Running Migrations

```bash
php artisan migrate
```

### Configuration File

After publishing, you can configure the package in `config/audit-center.php`:

```php
return [
    // User model class
    'user_model' => \App\Models\User::class,

    // Route configuration
    'routes' => [
        'prefix' => 'api/audit-logs',
        'middleware' => ['auth:sanctum', 'admin'],
    ],

    // Middleware configuration
    'middleware' => [
        'api_prefix' => 'api',
        'logged_methods' => ['POST', 'PUT', 'PATCH', 'DELETE'],
        'excluded_routes' => [
            'api/audit-logs*',
            'api/user',
            'api/login',
            'api/register',
            'api/logout',
        ],
        'sensitive_fields' => [
            'password',
            'password_confirmation',
            'token',
            'api_token',
        ],
        'auto_register' => false, // Set to true for automatic middleware registration
    ],
];
```

## Usage

### Middleware Registration

The package can automatically register the audit logging middleware, or you can register it manually:

#### Option 1: Auto-register (Recommended for Laravel 11+)

In `config/audit-center.php`, set:

```php
'middleware' => [
    'auto_register' => true,
],
```

#### Option 2: Manual Registration

In `bootstrap/app.php` (Laravel 11+):

```php
use AdriCeci\AuditCenter\Http\Middleware\AuditLogMiddleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->api(append: [
        AuditLogMiddleware::class,
    ]);
})
```

Or in `app/Http/Kernel.php` (Laravel 10):

```php
protected $middlewareGroups = [
    'api' => [
        // ... other middleware
        \AdriCeci\AuditCenter\Http\Middleware\AuditLogMiddleware::class,
    ],
];
```

### Manual Audit Logging

You can manually create audit log entries in your controllers:

```php
use AdriCeci\AuditCenter\Models\AuditLog;

AuditLog::log(
    action: 'login',
    description: 'User logged in successfully',
    userId: auth()->id(),
);
```

### Vue.js Components

#### Publishing Vue Assets

```bash
php artisan vendor:publish --tag=audit-center-vue-source
```

This will publish the Vue components to `resources/js/vendor/audit-center/`.

#### Configuring Vue Components

In your Vue application, configure the API service:

```javascript
// In your main.js or app.js
window.auditCenterConfig = {
  apiPrefix: "/api/audit-logs",
  apiService: ApiService, // Your API service instance
};
```

#### Using the Component

In your router or component:

```javascript
import AuditLogs from '@/vendor/audit-center/components/AuditLogs.vue';

// In your router
{
    path: '/audit-logs',
    name: 'audit-logs',
    component: AuditLogs,
}
```

Or use the composable directly:

```javascript
import { useAuditLogs } from "@/vendor/audit-center/composables/useAuditLogs";

const { auditLogs, fetchAuditLogs, loading } = useAuditLogs();
```

## API Endpoints

The package provides the following API endpoints:

- `GET /api/audit-logs` - List audit logs (with filtering and pagination)
- `GET /api/audit-logs/{id}` - Get a specific audit log
- `GET /api/audit-logs/stats` - Get audit log statistics
- `POST /api/audit-logs` - Create an audit log (manual)
- `PUT /api/audit-logs/{id}` - Update an audit log (manual)
- `DELETE /api/audit-logs/{id}` - Delete an audit log (soft delete)

### Query Parameters

For `GET /api/audit-logs`:

- `action` - Filter by action type
- `user_id` - Filter by user ID
- `from_date` - Filter from date (YYYY-MM-DD)
- `to_date` - Filter to date (YYYY-MM-DD)
- `per_page` - Items per page (default: 15)
- `page` - Page number

## Frontend Requirements

The Vue components expect:

- Vue 3
- A Table component from `@/components/ui` (or adjust imports)
- An API service compatible with the expected interface (see `useAuditLogs.js`)

## Customization

### Custom User Model

If you use a different User model:

```php
// config/audit-center.php
'user_model' => \App\Models\CustomUser::class,
```

### Custom Route Prefix

```php
// config/audit-center.php
'routes' => [
    'prefix' => 'api/admin/audit-logs',
],
```

### Excluding Routes

Add routes to exclude from automatic logging:

```php
'middleware' => [
    'excluded_routes' => [
        'api/audit-logs*',
        'api/custom-route*',
    ],
],
```

## Requirements

- PHP >= 8.2
- Laravel >= 12.0
- Vue 3 (for frontend components)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Support

For issues and questions, please open an issue on [GitHub](https://github.com/adriceci/audit-center).
