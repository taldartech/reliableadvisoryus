# HAP Frontend

Laravel + Bootstrap frontend for the HAP e-commerce platform. Consumes the [hap_backend](https://github.com/your-org/hap_backend) REST API.

## Requirements

- PHP 8.2+
- Composer
- [hap_backend](https://github.com/your-org/hap_backend) running (e.g. `php artisan serve` on port 8000)

## Setup

1. Install dependencies:
   ```bash
   composer install
   ```

2. Copy environment and set backend API URL:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Edit `.env` and set:
   - `HAP_API_URL=http://localhost:8000/api` (or your backend URL)
   - `HAP_API_TIMEOUT=15`

3. Session driver is set to `file` by default (no database required for the frontend).

## Run

```bash
php artisan serve
```

Then open http://localhost:8000 (or the port shown). If the backend runs on 8000, run the frontend on another port, e.g.:

```bash
php artisan serve --port=8001
```

## Features

- **Auth:** Login, register, logout (token stored in session)
- **Catalog:** Home, categories, product list, product detail
- **Cart:** View, add, update quantity, remove, clear (requires login)
- **Checkout:** Select addresses, coupon, payment method; place order
- **Orders:** List orders, order detail
- **Profile:** View/update profile, manage addresses

All data is fetched from the backend API. Ensure the backend is running and has run migrations (and optionally seed data) before using the frontend.
