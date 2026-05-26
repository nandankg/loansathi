# Deploying LoanSathi to Hostinger Shared Hosting

This guide targets the **Hostinger Single plan** — File Manager only, no SSH,
no remote Composer/Node. The same flow works on Premium/Business too; you'll
just have extra optional tools at your disposal.

Estimated time: **30–45 minutes** for the first deploy. Re-deploys take 5–10 minutes.

---

## Prerequisites — once per workstation

On your local machine you need:

- **PHP 8.1+**, **Composer 2**, **Node 18+**, **npm**
- The LoanSathi repo cloned and working locally (`composer test` passes)
- A Hostinger account with a registered domain pointed at it
- Login to **hPanel** (Hostinger's control panel)

---

## Step 1 — hPanel setup

### 1.1 PHP version

`hPanel → Websites → Manage → Advanced → PHP Configuration`

- **PHP version:** 8.1 or 8.2 (NOT 7.x)
- Click "Save"

### 1.2 MySQL database

`hPanel → Websites → Manage → Databases → Management → Create new`

Note these — you'll need them in `.env` and `src/config/db.php`:
- **Database name:** e.g. `u123456_loansathi`
- **DB username:** e.g. `u123456_loansathi`
- **DB password:** (generate a strong one)
- **DB host:** usually `localhost` (Hostinger's docs occasionally show `127.0.0.1`; both work)

### 1.3 Email account

`hPanel → Emails → Email Accounts → Create new`

- Create `leads@yourdomain.in` (or any mailbox where you want lead notifications to land)
- Save the password
- Note SMTP settings: usually `smtp.hostinger.com`, port `587` (TLS) or `465` (SSL)

### 1.4 SSL

`hPanel → Websites → Manage → Security → SSL`

- Click "Install" if not already done. Wait 5–10 minutes for issuance.
- Once active, enable "Force HTTPS"

---

## Step 2 — Build a release locally

In the project root on your workstation:

```bash
bin/build-release.sh
```

On Windows, use Git Bash (or the XAMPP shell). The script:

1. Builds production CSS (`npm run build`)
2. Installs PHP deps without dev packages (`composer install --no-dev`)
3. Copies the right files into `release/loansathi-YYYYMMDD-HHMM/`
4. Drops in the deploy `.htaccess` files and `setup.php`
5. Strips junk from `vendor/` (`.git`, tests, docs)
6. Zips the lot

Output: `release/loansathi-YYYYMMDD-HHMM.zip` (typically 4–8 MB).

---

## Step 3 — Upload

`hPanel → Files → File Manager → public_html/`

1. **Empty `public_html/`** first (Hostinger ships a `default.php` landing page — select all, delete)
2. **Upload the release zip** via the File Manager's "Upload Files" button
3. **Right-click the zip → Extract** into `public_html/`
4. The zip extracts to `public_html/loansathi-YYYYMMDD-HHMM/`. **Move every file out** of that subfolder up into `public_html/` itself (the `.htaccess` we ship MUST be at `public_html/.htaccess`, not nested). Then delete the empty subfolder.

After this, `public_html/` should look like:

```
public_html/
├── .htaccess              ← deploy htaccess-root (routes through /public/)
├── public/                ← web-facing assets + index.php
├── src/                   ← app code (denied by .htaccess inside)
├── bin/                   ← install.php (denied)
├── vendor/                ← Composer deps (denied)
├── storage/               ← logs (denied)
├── composer.json
└── .env.example
```

---

## Step 4 — Configure environment

Two files need editing on the server:

### 4.1 `src/config/db.php` (NOT shipped — you create it)

In File Manager: copy `src/config/db.php.example` → `src/config/db.php`. Edit and fill in:

```php
<?php
return [
  'host'     => 'localhost',
  'port'     => 3306,
  'database' => 'u123456_loansathi',     // from Step 1.2
  'username' => 'u123456_loansathi',
  'password' => 'YOUR_DB_PASSWORD',
  'charset'  => 'utf8mb4',
];
```

### 4.2 `.env` (copy from `.env.example`)

In File Manager: copy `.env.example` → `.env`. Edit. Required values:

```
APP_ENV=production
BASE_URL=https://yourdomain.in

CONTACT_PHONE=+919876543210
CONTACT_PHONE_DISPLAY=+91 98765 43210
CONTACT_WHATSAPP=919876543210
CONTACT_EMAIL=hello@yourdomain.in
CONTACT_LEAD_INBOX=leads@yourdomain.in

SMTP_HOST=smtp.hostinger.com
SMTP_PORT=587
SMTP_USER=leads@yourdomain.in
SMTP_PASS=THE_MAILBOX_PASSWORD_FROM_STEP_1.3
SMTP_SECURE=tls
SMTP_FROM=leads@yourdomain.in

SETUP_KEY=PUT_A_LONG_RANDOM_STRING_HERE
```

**Generate a SETUP_KEY** — any 32+ random alphanumeric string. Example:
`9f4a2b8c1d7e3f5a6b8c9d0e1f2a3b4c`. You'll use it once and then delete `setup.php`.

---

## Step 5 — Run setup once

In your browser, visit:

```
https://yourdomain.in/setup.php?key=YOUR_SETUP_KEY
```

You'll see a form. Fill in:
- **Username** (e.g. `admin`)
- **Full name**
- **Password** (10+ chars — use a strong one)

Submit. The page will:
1. Create the four DB tables (`leads`, `admin_users`, `posts`, `rate_limit_log`)
2. Create your first admin user

A green success box appears.

### 5.1 Delete setup.php (CRITICAL)

`File Manager → public/setup.php → Delete`

The file self-protects (refuses to run after an admin exists), but leaving deploy
helpers on a prod server is bad hygiene. Delete it.

---

## Step 6 — Verify

Hit each URL in your browser:

| URL | Expected |
|---|---|
| `https://yourdomain.in/` | Homepage renders with new styling. Hero, tools section, loan tiles, lead form. No console errors. |
| `https://yourdomain.in/no-such-page` | Branded 404 page, HTTP 404 in network tab. |
| `https://yourdomain.in/personal-loan` | "Coming soon" page (Plan 2 will replace these with real content). |

### 6.1 Submit a real lead

1. Fill the form on the homepage. Submit.
2. You should see the inline thank-you message.
3. Check the `leads` table in `hPanel → Databases → phpMyAdmin`:
   ```sql
   SELECT id, name, phone, loan_type, created_at
   FROM leads ORDER BY id DESC LIMIT 5;
   ```
4. Check the `leads@yourdomain.in` inbox — a notification email should be waiting.

If the email didn't arrive, check `storage/logs/php-error-*.log` via File Manager
for `[mailer]` lines indicating SMTP failure, then double-check `.env`'s SMTP_*
values match what Hostinger's email panel shows.

---

## Re-deploying after changes

Once set up, each future release is:

1. Locally: `bin/build-release.sh` → produces a new zip
2. In hPanel File Manager, delete the old `public/`, `src/`, `vendor/` folders
3. Upload the new zip, extract, move files up — same as Step 3
4. **Do NOT overwrite** `.env` or `src/config/db.php` — they're not in the zip
5. **No need to re-run setup.php** — the schema is idempotent if you keep it,
   but you've deleted it. If new tables are added in future, add a migrations
   script or use phpMyAdmin to run SQL.

---

## Troubleshooting

### Homepage shows the raw PHP code

`.htaccess` not being applied. Confirm via hPanel that `mod_rewrite` is enabled
(Hostinger has it on by default). Also confirm the `.htaccess` files made it
into `public_html/.htaccess` AND `public_html/public/.htaccess`.

### "500 Internal Server Error"

Check `storage/logs/php-error-YYYY-MM-DD.log` via File Manager. Usually:
- Wrong PHP version (need 8.1+)
- `src/config/db.php` missing or has wrong creds
- `.env` malformed (unbalanced quotes etc.)

### Leads save but no email arrives

SMTP not configured correctly. Edit `.env`, double-check `SMTP_*` values. Hostinger
sometimes requires `SMTP_SECURE=ssl` and `SMTP_PORT=465` instead of TLS/587.

### "Database connection failed"

DB user can't reach the DB. Verify in phpMyAdmin you can log in with the same
username/password. Then check the user has been granted access to the DB
(`hPanel → Databases → Management → user list → check the privileges column`).

### Setup.php says "Forbidden"

The `?key=` URL parameter doesn't match `SETUP_KEY` in `.env`. They must be
byte-for-byte identical. Don't paste with leading/trailing spaces.

### Lead form gets "CSRF" error from the JS

PHP sessions aren't persisting. Hostinger's PHP session save path defaults
fine; this only breaks if you've changed `session.save_path` somewhere. The
fix is usually visiting `/` once first to set the session cookie before
submitting the form (which the regular user flow always does).

### Page works on Hostinger preview URL but not custom domain

DNS still propagating. Wait 1–4 hours after pointing nameservers at Hostinger.

---

## Optional hardening (do these once the site is live)

- **Lock down phpinfo / debugging:** confirm `.env` has `APP_ENV=production` —
  this hides stack traces.
- **Backup schedule:** `hPanel → Files → Backup Manager` — enable daily.
- **Cron jobs:** `hPanel → Advanced → Cron Jobs`. Schedule a weekly prune of
  the rate-limit log:
  ```
  0 3 * * 0 /usr/bin/php /home/uXXXXXXX/public_html/bin/cron-prune.php
  ```
  (We'll add that script in Plan 4.)
- **Tighten CSP:** edit `public/.htaccess`, remove `'unsafe-inline'` from
  `script-src` once we extract inline Alpine handlers to external files
  (Plan 3 cleanup task).
- **Disable directory listing:** add `Options -Indexes` at the top of the
  root `.htaccess`. Already done in our shipped file.

---

## Quick reference — what lives where

| Local path                         | Server path                                |
|------------------------------------|--------------------------------------------|
| `public/*`                         | `public_html/public/*`                     |
| `src/*`                            | `public_html/src/*` (denied by .htaccess)  |
| `vendor/*`                         | `public_html/vendor/*` (denied)            |
| `bin/*`                            | `public_html/bin/*` (denied)               |
| `storage/logs/`                    | `public_html/storage/logs/` (denied)       |
| `deploy/htaccess-root`             | `public_html/.htaccess`                    |
| `deploy/setup.php`                 | `public_html/public/setup.php` (DELETE after install) |
| `.env`                             | `public_html/.env` (NOT in repo or zip — you create on server) |
| `src/config/db.php`                | `public_html/src/config/db.php` (NOT in zip — you create on server) |
