-- Run as MariaDB/MySQL root (or admin) so the app user can create tenant databases.
-- Replace 'pbx' and host if your .env differs.

-- Minimum for php artisan tenants:create (new tenants)
GRANT CREATE, DROP, ALTER, REFERENCES ON *.* TO 'pbx'@'127.0.0.1';

-- If the tenant database already exists (e.g. grupogoba_production), grant access to it:
GRANT ALL PRIVILEGES ON `grupogoba_production`.* TO 'pbx'@'127.0.0.1';

FLUSH PRIVILEGES;
