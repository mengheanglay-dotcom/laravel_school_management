# CampusFlow — School Management

A responsive Laravel school-facilities and staff management app built with Blade and Tailwind CSS. It includes a dashboard, buildings, floors, classrooms, and teacher directories with create, search, edit, delete, validation, and pagination.

## Requirements
- PHP 8.3 or newer
- Composer
- Node.js and npm (for the Vite/Tailwind build)
- SQLite (default) or MySQL

## 1. Extract and open the project
Extract `school_management.zip`, then open the `school_management` folder in VS Code or your terminal.

## 2. Install dependencies
```bash
composer install
npm install
```

## 3. Configure environment
Copy `.env.example` to `.env` (on Windows PowerShell: `Copy-Item .env.example .env`). Then run:
```bash
php artisan key:generate
```

SQLite is configured by default. Create the SQLite file if it does not exist:
- Windows PowerShell: `New-Item database/database.sqlite -ItemType File`
- macOS/Linux: `touch database/database.sqlite`

Make sure `.env` has `DB_CONNECTION=sqlite`. If using MySQL instead, create a database and set `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

## 4. Run database migrations
For a brand-new database:
```bash
php artisan migrate
```

**Important for this updated project:** the original `rooms` migration did not define the room number or floor relationship, so its migration has been corrected, and floors/rooms now have per-building/per-floor uniqueness. If you have already migrated the old version, back up your data first, then for this development project rebuild the schema with:
```bash
php artisan migrate:fresh
```
`migrate:fresh` DROPS ALL TABLES and deletes all data in the configured database. Do not run it against a database whose data you need to keep. For production/valuable data, create a separate forward migration and migrate the data carefully instead.

Optional demo data can be added by editing `database/seeders/DatabaseSeeder.php`.

## 5. Build frontend assets
```bash
npm run build
```
For development with live reload, use `npm run dev` in its own terminal instead.

## 6. Link teacher photo storage
```bash
php artisan storage:link
```

## 7. Start Laravel
```bash
php artisan serve
```
Open the URL shown by Laravel, usually http://127.0.0.1:8000.

## Features
- Responsive dashboard with totals for buildings, floors, classrooms, and teachers
- Quick-action shortcuts
- CRUD management for buildings, floors, classrooms, and teachers
- Search across directories; teacher subject filter
- Pagination and validation messages
- Teacher photo uploads (JPG, PNG, WEBP; max 2 MB)
- Relationship-aware lists (building → floors → classrooms)
- Duplicate floor labels within the same building and duplicate room numbers on the same floor are prevented
- Delete confirmation and protection from deleting buildings/floors that still contain child records
- Existing JSON API endpoints remain available under `/api/*`

## API endpoints
- `GET/POST /api/buildings`, `GET/PUT/DELETE /api/buildings/{building}`
- `GET/POST /api/floors`, `GET/PUT/DELETE /api/floors/{floor}`
- `GET/POST /api/rooms`, `GET/PUT/DELETE /api/rooms/{room}`
- `GET/POST /api/teachers`, `GET/PUT/DELETE /api/teachers/{teacher}`
- `POST /api/register`, `POST /api/login`

The browser UI routes are `/`, `/buildings`, `/floors`, `/rooms`, and `/teacher` (with the existing `/teachers` resource routes also available).

## Troubleshooting
- If Tailwind styling is missing, run `npm run build` and refresh the browser.
- If teacher photos do not display, run `php artisan storage:link`.
- If you change `.env`, run `php artisan config:clear`.
- If a database table/column is missing after upgrading from the old version, verify the migration status with `php artisan migrate:status`; on a disposable development database only, use `php artisan migrate:fresh`.
- If you see a permission or cache issue, run `php artisan optimize:clear`.

## Notes
The dashboard is currently an admin-style interface and does not implement browser login/role authorization. The existing register/login JSON API routes are retained separately. Add session authentication and authorization middleware before deploying the web interface to a public server.
