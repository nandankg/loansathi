# Deploying LoanSathi To Shared Hosting

This project is designed for simple PHP/MySQL shared hosting such as Hostinger,
cPanel, DirectAdmin, or similar providers. The server does not need Node, npm,
Composer, or SSH if you upload the prepared release zip.

## Requirements

- PHP 8.1 or newer
- MySQL 5.7+/MariaDB 10.3+
- Apache with `.htaccess`/`mod_rewrite`
- PHP extensions: PDO MySQL, OpenSSL, mbstring, json

## 1. Build A Release Locally

From the project root:

```bash
npm run build
composer install --no-dev --optimize-autoloader
bin/build-release.sh
```

The release zip is written to `release/loansathi-YYYYMMDD-HHMM.zip`.

## 2. Upload

In your hosting file manager:

1. Open `public_html/`.
2. Remove the host's default placeholder files.
3. Upload and extract the release zip.
4. Move the extracted files up so `.htaccess`, `public/`, `src/`, `vendor/`,
   `storage/`, and `.env.example` are directly inside `public_html/`.

Expected layout:

```text
public_html/
  .htaccess
  public/
  src/
  vendor/
  storage/
  bin/
  composer.json
  .env.example
```

## 3. Configure `.env`

Copy `.env.example` to `.env` and fill in your real values:

```dotenv
APP_ENV=production
BASE_URL=https://yourdomain.in

CONTACT_PHONE=+919876543210
CONTACT_PHONE_DISPLAY="+91 98765 43210"
CONTACT_WHATSAPP=919876543210
CONTACT_EMAIL=hello@yourdomain.in
CONTACT_LEAD_INBOX=leads@yourdomain.in

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456_loansathi
DB_USERNAME=u123456_loansathi
DB_PASSWORD=your-database-password
DB_CHARSET=utf8mb4

SMTP_HOST=smtp.hostinger.com
SMTP_PORT=587
SMTP_USER=leads@yourdomain.in
SMTP_PASS=your-mailbox-password
SMTP_SECURE=tls
SMTP_FROM=leads@yourdomain.in

SETUP_KEY=put-a-long-random-string-here
```

`src/config/db.php` is optional. Use it only if you prefer PHP config files.
For shared hosting, keeping database credentials in `.env` is usually simpler.

Any `.env` value with spaces must be wrapped in double quotes.

## 4. Run Setup Once

Visit:

```text
https://yourdomain.in/setup.php?key=YOUR_SETUP_KEY
```

Create the first admin user. The setup page creates the required tables:
`leads`, `admin_users`, `posts`, and `rate_limit_log`.

After setup succeeds, delete:

```text
public/setup.php
```

## 5. Verify

Check these URLs:

- `/` renders the homepage.
- `/submit-lead` rejects GET requests with JSON.
- Submit the homepage lead form and confirm a row appears in `leads`.
- `/admin/login` lets you sign in with the setup admin.
- `/admin/leads` lists submitted leads.
- `/no-such-page` shows the branded 404 page.

## Troubleshooting

If the homepage returns 500, check `storage/logs/php-error-YYYY-MM-DD.log`.
The most common causes are wrong PHP version, missing `vendor/`, bad `.env`
syntax, or incorrect database credentials.

If pretty URLs return 404, make sure `.htaccess` files were uploaded and the
host allows Apache rewrites.

If leads save but emails do not arrive, verify `SMTP_*` values. Some hosts use
`SMTP_SECURE=ssl` with `SMTP_PORT=465` instead of TLS/587.

If sessions or CSRF fail, confirm the `storage/` folder exists and is writable.
The app now creates `storage/logs` and `storage/sessions` automatically when
the hosting account allows it.
