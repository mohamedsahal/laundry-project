# Laundry Management System

A web application for laundry shops, built with Laravel 11, Livewire 3 and Tailwind CSS:
POS order entry, order status tracking, customers and ledgers, services and add-ons, payments,
expenses, inventory with purchases and stock usage, PDF/Excel reports, roles and permissions,
and a translatable (RTL-capable) interface.

This project is developed and run by developers only — there is no web installer, updater or
licence check. Set it up from the command line as below.

## Requirements

- PHP 8.2+ with the usual Laravel extensions (pdo_mysql, mbstring, gd, zip, curl)
- Composer
- MySQL 8
- Node.js 18+ (Vite builds the assets)

## Setup

```bash
composer install
cp .env.example .env            # then set DB_DATABASE / DB_USERNAME / DB_PASSWORD
php artisan key:generate
php artisan migrate --seed      # tables, settings, countries, units, services, permissions, admin user
php artisan storage:link        # service icons are uploaded to storage/app/public
npm install && npm run build    # or `npm run dev` while working on the UI
php artisan serve
```

Sign in at <http://127.0.0.1:8000> with **admin@admin.com / 123456**, then change the password
under Settings → Staff.

Optional demo data (customers, orders, payments, expenses, purchases, stock usage):

```bash
php artisan db:seed --class=SampleDataSeeder
```

## Notes

- Mail settings saved in Settings → Mail are written to `.env` (via `jackiedo/dotenv-editor`).
- Reports export through DomPDF (PDF) and Laravel Excel (XLSX).
- `docs/proposal/` holds the diagrams used in the project proposal.
