# LoanSathi

Loan consultancy website for Indian customers.

## Stack
PHP 8.1+, MySQL, Tailwind CSS (compiled), Alpine.js, PHPMailer.

## Local development

Prereqs: XAMPP (Apache + MySQL + PHP 8.1), Node 18+, Composer 2.

```bash
# Install deps
composer install
npm install

# Copy config
cp src/config/db.php.example src/config/db.php
# Edit src/config/db.php with your local DB credentials

# Create DB and tables
php bin/install.php

# Compile Tailwind (watch mode)
npm run dev

# Point XAMPP Apache DocumentRoot to ./public/
```

## Production build

```bash
npm run build           # minified CSS
php bin/install.php     # idempotent: creates tables if missing
```

## Tests

```bash
composer test
```
