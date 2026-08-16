# Laravel Roles & Permissions

A Laravel 10 application demonstrating role-based access control (RBAC), user administration, authorization policies, login-device detection, external IP geolocation, email notifications, feature testing and a Docker-based development environment.

This repository originated from a technical implementation brief and has been retained as a portfolio example of Laravel backend engineering. The application models three roles — **Admin**, **Content Manager** and **User** — with permissions controlling access to the administrative interface and user-management operations.

## What the project demonstrates

- Laravel 10 application structure on PHP 8.1+
- Authentication and email verification through Laravel Breeze
- Role-based access control using custom `Role` and `Permission` models
- Many-to-many user/role and role/permission relationships
- Policy-based authorization for administrative actions
- Middleware-enforced access for Admin and Content Manager areas
- User create, read, update and delete workflows
- Form Request validation for user-management operations
- Login IP / user-agent tracking
- New-device login email notifications
- External IP geolocation lookup
- Database factories and seeders
- PHPUnit feature and authentication tests
- GitHub Actions workflow for dependency installation, frontend build and test execution
- Docker Compose / Laravel Sail development environment
- MySQL, Redis, MailHog, Meilisearch, Selenium and phpMyAdmin services available in the development stack

> Redis and Meilisearch are present in the Docker development environment, but this README does not claim application-level caching or search features beyond what the current source code implements.

## Authorization model

The application uses roles and permissions rather than relying only on route-level role checks.

### Roles

- **Admin** — can view the administrative area and administer users.
- **Content Manager** — can view the manager dashboard but cannot administer users.
- **User** — standard application access without administrative permissions.

### Permissions

The current permission model includes:

- `view-admin-dashboard`
- `administer-users`

`UserPolicy` centralizes authorization decisions for dashboard access and user-management operations, while route middleware protects the Admin and Manager route groups.

## User-management flow

Administrators can:

- View and search users
- Create users
- Assign one or more roles
- View user details
- Update user information and roles
- Delete users

Validated user-management input is handled with Laravel Form Requests. Role assignments are persisted through the user/role pivot relationship.

## Login-device detection

When a user authenticates, the application records the current IP address, user agent, login timestamp and a location value.

If the stored IP address or user agent changes, the application:

1. Attempts to resolve the IP address through an external geolocation service.
2. Updates the user's stored login-location information.
3. Sends a new-device login email notification.

The current implementation uses the `ip-api.com` HTTP endpoint and falls back to a generated city value when a location cannot be resolved. This is suitable for demonstrating the workflow, but a production implementation should use an HTTPS-capable provider, explicit timeouts/retries and deterministic failure handling.

## Testing

The repository includes Laravel feature tests for the RBAC and user-management behavior, including:

- Unauthenticated access restrictions
- Admin permission checks
- Content Manager permission checks
- Standard-user restrictions
- Admin user creation
- Admin user updates
- Admin user deletion
- Admin and manager dashboard access
- Invalid create/update requests

Run the PHP test suite with:

```bash
php artisan test
```

or:

```bash
./vendor/bin/phpunit
```

The repository also contains the standard Breeze authentication feature tests under `tests/Feature/Auth`.

### Continuous integration

`.github/workflows/ci.yml` is configured to install locked Composer and npm dependencies, build the frontend assets and run the Laravel test suite against SQLite on pushes and pull requests targeting `master`.

The presence of the workflow should not be interpreted as a successful fresh verification until GitHub Actions has completed a run successfully.

## Technology stack

### Application

- PHP 8.1+
- Laravel 10
- Laravel Breeze
- Laravel Sanctum
- PHPUnit 10
- Blade
- Tailwind CSS
- Alpine.js
- Vite

### Development infrastructure

The Docker Compose configuration provides:

- PHP / Laravel application container
- MySQL 8
- Redis
- Meilisearch
- MailHog
- Selenium / Chrome
- phpMyAdmin

The application container is based on the repository's Laravel Sail-style Docker configuration.

## Local setup

### Prerequisites

For a direct local installation:

- PHP 8.1 or newer
- Composer
- Node.js / npm
- MySQL

For the containerized environment:

- Docker
- Docker Compose

### Direct installation

```bash
git clone https://github.com/hyltonwalters/laravel-roles-and-permissions.git
cd laravel-roles-and-permissions
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Configure the database and mail settings in `.env`, then run:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

### Docker / Sail-style environment

After installing PHP dependencies and creating `.env`:

```bash
docker compose up -d --build
```

Then run migrations and seeders in the application container using your preferred Docker Compose / Sail workflow.

The Compose file exposes the application on `${APP_PORT:-80}` and phpMyAdmin on port `8001` by default.

## Project structure

Key areas to review:

- `app/Models/User.php` — role/permission helpers and relationships
- `app/Models/Role.php` — role model and permission relationship
- `app/Models/Permission.php` — permission model and constants
- `app/Policies/UserPolicy.php` — authorization rules
- `app/Http/Middleware/` — role-aware route middleware
- `app/Http/Controllers/Admin/UserController.php` — administrative user management
- `app/Http/Controllers/Manager/UserController.php` — manager dashboard behavior
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` — login/device tracking workflow
- `app/Http/Requests/Auth/` — user-management validation
- `database/seeders/` — default users, roles and permissions
- `tests/Feature/UserRolesAndPermissionsTest.php` — RBAC and user-management feature coverage
- `docker-compose.yml` — local development services
- `.github/workflows/ci.yml` — automated build/test verification

## Engineering observations / future hardening

The repository demonstrates the intended backend concepts, but several areas would be worth hardening before treating it as production-ready:

- Use an HTTPS-capable geolocation provider and configure request timeouts/retries.
- Remove non-deterministic fake location fallback from application behavior.
- Consolidate duplicated Admin/Manager dashboard query logic.
- Ensure routes use the intended Manager controller consistently.
- Add tests around login-device detection and notification behavior.
- Review and trim development services that are not used by application code.
- Upgrade dependencies deliberately and verify compatibility before any framework-version migration.
- Add structured error handling around external service failures.

## Project context

This project was developed from an implementation brief supplied by **PlusNarrative**. The brief required a Laravel user administration system with roles, permissions, protected routes and login-device notification behavior. The implementation in this repository is Hylton Walters' project work based on those requirements.

## Current status

This repository is maintained primarily as a portfolio example of Laravel backend engineering. The source has been reviewed for documentation accuracy, but the current branch should not be represented as freshly runtime-verified until its dependencies, migrations, automated tests and Docker environment have been executed successfully on a clean environment.

## License

This project is licensed under the [MIT License](LICENSE).
