# PBX Back

Laravel API with multi-tenant architecture (`stancl/tenancy`), session token auth, and Bouncer authorization.

## Requirements

- PHP 8.2+
- Composer
- MySQL

## Setup

1. Configure `.env` from `.env.example` (central database `pbx_central`).
2. Run central migrations:

```bash
php artisan migrate
```

3. Grant the app DB user permission to create tenant databases (once, as root):

```bash
# Edit database/sql/grant-tenant-database-privileges.sql if needed, then run in your SQL client.
```

4. Create a tenant:

```bash
php artisan config:clear
php artisan tenants:create demo
```

If `grupogoba_production` (or similar) **already exists**, grant `ALL` on that database to your app user (see SQL file) instead of enabling `TENANCY_DROP_DATABASE_BEFORE_CREATE`.

This creates the tenant database, runs tenant migrations, and seeds default admin:

- Email: `admin@pbx.local`
- Password: `password`

## Local URL

Configure Herd/Valet site as `pbx-back.test`.

API routes are registered under `/api/admin` (use `X-Tenant` header from the frontend).

## Stack

- Laravel 13
- stancl/tenancy
- silber/bouncer
- spatie/laravel-route-attributes
- Custom `pbx-token` guard (session table)
