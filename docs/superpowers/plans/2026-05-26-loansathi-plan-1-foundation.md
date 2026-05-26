# LoanSathi — Plan 1: Foundation, Pipeline & Lead Capture

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a deployable PHP scaffold for the LoanSathi website with routing, DB schema, core library (CSRF, validator, mailer, auth, calculator, eligibility), a working lead-capture pipeline (form → DB → email), and a minimal homepage that proves the pipeline end-to-end.

**Architecture:** Plain PHP 8.1+ with a single front controller (`public/index.php`) and a tiny custom router (~50 LOC). Tailwind compiled via npm. Alpine.js (CDN, deferred) for form interactivity. PDO for MySQL. PHPMailer for SMTP. No framework. Built for shared LAMP hosting.

**Tech Stack:** PHP 8.1+, MySQL 5.7+/MariaDB, Tailwind CSS (compiled), Alpine.js, PHPMailer (via Composer), PHPUnit (dev), Parsedown (added in later plan).

**Companion plans (written after this one is executed):**
- Plan 2: Public content pages (7 loan landings, About/Contact/Legal, Application Guide)
- Plan 3: Interactive tools (EMI, Eligibility, Comparison)
- Plan 4: Admin + Blog + SEO Hardening

**Reference spec:** `docs/superpowers/specs/2026-05-26-loan-consultant-website-design.md`

---

## File Map (created in this plan)

```
loan_consultant/
├── public/
│   ├── index.php                 ← Task 12
│   ├── .htaccess                 ← Task 13
│   ├── assets/
│   │   ├── css/site.css          ← Task 6 (compiled output)
│   │   └── images/.gitkeep
│   └── robots.txt                ← Task 13
├── src/
│   ├── input.css                 ← Task 5
│   ├── lib/
│   │   ├── db.php                ← Task 9
│   │   ├── router.php            ← Task 15
│   │   ├── csrf.php              ← Task 18
│   │   ├── validator.php         ← Task 20
│   │   ├── mailer.php            ← Task 22
│   │   ├── auth.php              ← Task 24
│   │   ├── calculator.php        ← Task 27
│   │   ├── eligibility.php       ← Tasks 29, 31, 33
│   │   └── helpers.php           ← Task 7 (utility funcs: e(), config())
│   ├── config/
│   │   ├── app.php               ← Task 7
│   │   ├── db.php.example        ← Task 8
│   │   └── db.php                ← Task 8 (gitignored)
│   ├── pages/
│   │   ├── home.php              ← Task 47–48
│   │   ├── 404.php               ← Task 49
│   │   └── thank-you.php         ← Task 50
│   ├── partials/
│   │   ├── seo-meta.php          ← Task 34
│   │   ├── header.php            ← Task 35
│   │   ├── footer.php            ← Task 36
│   │   ├── whatsapp-fab.php      ← Task 37
│   │   ├── breadcrumbs.php       ← Task 38
│   │   ├── cookie-banner.php     ← Task 39
│   │   └── lead-form.php         ← Task 41
│   └── handlers/
│       └── submit-lead.php       ← Task 44
├── bin/
│   └── install.php               ← Task 10
├── storage/
│   └── logs/.gitkeep             ← Task 1
├── tests/
│   └── unit/
│       ├── CalculatorTest.php    ← Task 26
│       ├── EligibilityTest.php   ← Tasks 28, 30, 32
│       ├── ValidatorTest.php     ← Task 19
│       ├── CsrfTest.php          ← Task 17
│       ├── RouterTest.php        ← Task 14
│       └── SubmitLeadTest.php    ← Tasks 42, 43
├── tailwind.config.js            ← Task 2
├── package.json                  ← Task 2
├── composer.json                 ← Task 3
└── README.md                     ← Task 51
```

---

## Phase A — Project Scaffold

### Task 1: Create directory structure

**Files:**
- Create: directory tree above
- Create: `public/assets/images/.gitkeep`, `storage/logs/.gitkeep` (empty marker files)

- [ ] **Step 1: Run scaffold command**

```bash
cd /c/xampp/htdocs/loan_consultant
mkdir -p public/assets/css public/assets/js public/assets/images public/assets/blog
mkdir -p src/lib src/config src/pages src/partials src/handlers src/admin
mkdir -p bin storage/logs tests/unit tests/integration
touch public/assets/images/.gitkeep public/assets/blog/.gitkeep storage/logs/.gitkeep
```

- [ ] **Step 2: Verify with `find`**

```bash
find . -type d -not -path './.git*' -not -path './node_modules*' | sort
```

Expected output includes: `./bin`, `./public`, `./public/assets/css`, `./src/lib`, `./tests/unit`, etc.

- [ ] **Step 3: Commit**

```bash
git add public/assets storage tests bin src
git commit -m "chore: scaffold directory structure"
```

---

### Task 2: Initialize npm + Tailwind

**Files:**
- Create: `package.json`
- Create: `tailwind.config.js`

- [ ] **Step 1: Create `package.json`**

```json
{
  "name": "loansathi",
  "version": "0.1.0",
  "private": true,
  "scripts": {
    "dev": "tailwindcss -i ./src/input.css -o ./public/assets/css/site.css --watch",
    "build": "tailwindcss -i ./src/input.css -o ./public/assets/css/site.css --minify"
  },
  "devDependencies": {
    "tailwindcss": "^3.4.0"
  }
}
```

- [ ] **Step 2: Create `tailwind.config.js`**

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './src/**/*.php',
    './public/**/*.php',
    './public/assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#0a2540',
          900: '#0a2540',
          800: '#0f3460',
        },
        brand: {
          blue: '#1e88e5',
          amber: '#f59e0b',
          slate: '#475569',
          surface: '#f7fafc',
        },
      },
      fontFamily: {
        sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        card: '0 4px 14px rgba(10, 37, 64, 0.08)',
        hero: '0 12px 32px rgba(10, 37, 64, 0.18)',
      },
    },
  },
  plugins: [],
};
```

- [ ] **Step 3: Install**

```bash
npm install
```

Expected: `node_modules/` created, no errors.

- [ ] **Step 4: Commit**

```bash
git add package.json package-lock.json tailwind.config.js
git commit -m "chore: add Tailwind config with LoanSathi palette"
```

---

### Task 3: Initialize Composer + dev dependencies

**Files:**
- Create: `composer.json`

- [ ] **Step 1: Create `composer.json`**

```json
{
  "name": "loansathi/site",
  "type": "project",
  "require": {
    "php": ">=8.1",
    "phpmailer/phpmailer": "^6.9"
  },
  "require-dev": {
    "phpunit/phpunit": "^10.5"
  },
  "autoload": {
    "files": [
      "src/lib/helpers.php"
    ]
  },
  "scripts": {
    "test": "phpunit tests --colors=always",
    "test:unit": "phpunit tests/unit --colors=always"
  }
}
```

- [ ] **Step 2: Install**

```bash
composer install
```

Expected: `vendor/` created, `composer.lock` written, PHPMailer + PHPUnit downloaded.

- [ ] **Step 3: Commit**

```bash
git add composer.json composer.lock
git commit -m "chore: add Composer with PHPMailer and PHPUnit"
```

---

### Task 4: Create README

**Files:**
- Create: `README.md`

- [ ] **Step 1: Write README**

```markdown
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
```

- [ ] **Step 2: Commit**

```bash
git add README.md
git commit -m "docs: add README"
```

---

## Phase B — Config & Database

### Task 5: Create Tailwind input CSS

**Files:**
- Create: `src/input.css`

- [ ] **Step 1: Write input.css**

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  html {
    -webkit-text-size-adjust: 100%;
    scroll-behavior: smooth;
  }
  body {
    @apply font-sans text-brand-slate bg-white antialiased;
  }
  h1, h2, h3, h4 {
    @apply font-sans font-extrabold text-navy tracking-tight;
  }
  a {
    @apply text-brand-blue hover:text-navy transition-colors;
  }
}

@layer components {
  .btn-primary {
    @apply inline-flex items-center justify-center bg-brand-amber text-navy font-bold px-5 py-3 rounded-lg shadow-card hover:bg-amber-400 transition-colors;
  }
  .btn-secondary {
    @apply inline-flex items-center justify-center bg-white text-navy border-2 border-navy font-bold px-5 py-3 rounded-lg hover:bg-navy hover:text-white transition-colors;
  }
  .btn-ghost {
    @apply inline-flex items-center justify-center text-navy font-semibold px-3 py-2 hover:text-brand-blue transition-colors;
  }
  .container-page {
    @apply mx-auto max-w-7xl px-4 sm:px-6 lg:px-8;
  }
  .input-field {
    @apply w-full rounded-lg border border-slate-300 px-4 py-3 text-navy placeholder:text-slate-400 focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/30 outline-none transition;
  }
  .input-field.error {
    @apply border-red-500 focus:border-red-500 focus:ring-red-200;
  }
  .error-text {
    @apply text-xs text-red-600 mt-1;
  }
}
```

- [ ] **Step 2: Commit**

```bash
git add src/input.css
git commit -m "feat: add Tailwind input stylesheet with brand tokens"
```

---

### Task 6: Compile Tailwind once to verify

- [ ] **Step 1: Run build**

```bash
npm run build
```

Expected: `public/assets/css/site.css` exists, sized 5–20KB.

- [ ] **Step 2: Verify**

```bash
ls -l public/assets/css/site.css
head -5 public/assets/css/site.css
```

Expected: First line shows `/*! tailwindcss ...`. File exists and is non-empty.

- [ ] **Step 3: Commit**

(`public/assets/css/site.css` is gitignored — nothing to commit. This task is a verification gate only.)

---

### Task 7: Create app config and helpers

**Files:**
- Create: `src/config/app.php`
- Create: `src/lib/helpers.php`

- [ ] **Step 1: Write `src/config/app.php`**

```php
<?php
return [
  'site_name'       => 'LoanSathi',
  'tagline'         => 'Your trusted loan companion',
  'base_url'        => (function() {
                        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
                        $scheme = (($_SERVER['HTTPS'] ?? '') === 'on') ? 'https' : 'http';
                        return $scheme . '://' . $host;
                      })(),
  'contact' => [
    'phone'         => '+91XXXXXXXXXX',
    'phone_display' => '+91 XXXXX XXXXX',
    'whatsapp'      => '91XXXXXXXXXX',
    'email'         => 'hello@loansathi.in',
    'lead_inbox'    => 'leads@loansathi.in',
  ],
  'smtp' => [
    'host'          => getenv('SMTP_HOST') ?: 'localhost',
    'port'          => (int)(getenv('SMTP_PORT') ?: 587),
    'username'      => getenv('SMTP_USER') ?: '',
    'password'      => getenv('SMTP_PASS') ?: '',
    'secure'        => getenv('SMTP_SECURE') ?: 'tls',
    'from_address'  => getenv('SMTP_FROM') ?: 'no-reply@loansathi.in',
    'from_name'     => 'LoanSathi',
  ],
  'gsc_verification' => '', // Google Search Console meta content
  'bing_verification' => '',
  'eligibility' => [
    'gold_rate_per_gram'   => 6000,
    'gold_ltv'             => 0.75,
    'home_max_emi_ratio'   => 0.55,
    'lap_ltv'              => 0.65,
    'vehicle_ltv'          => 0.85,
    'business_multiplier'  => 0.30,
    'edu_no_collateral_cap' => 750000,
    'edu_with_collateral_cap' => 5000000,
  ],
  'loan_types' => [
    'personal'  => 'Personal Loan',
    'home'      => 'Home Loan',
    'business'  => 'Business Loan',
    'gold'      => 'Gold Loan',
    'lap'       => 'Loan Against Property',
    'education' => 'Education Loan',
    'vehicle'   => 'Vehicle Loan',
  ],
];
```

- [ ] **Step 2: Write `src/lib/helpers.php`**

```php
<?php
// Global helper functions. Autoloaded via composer.json files array.

if (!function_exists('config')) {
    function config(?string $key = null, $default = null) {
        static $cfg = null;
        if ($cfg === null) {
            $cfg = require __DIR__ . '/../config/app.php';
        }
        if ($key === null) return $cfg;
        $parts = explode('.', $key);
        $val = $cfg;
        foreach ($parts as $p) {
            if (!is_array($val) || !array_key_exists($p, $val)) return $default;
            $val = $val[$p];
        }
        return $val;
    }
}

if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string {
        $base = rtrim(config('base_url'), '/');
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, int $status = 302): void {
        header('Location: ' . $url, true, $status);
        exit;
    }
}

if (!function_exists('json_response')) {
    function json_response($data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

if (!function_exists('client_ip')) {
    function client_ip(): string {
        return $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['REMOTE_ADDR']
            ?? '0.0.0.0';
    }
}
```

- [ ] **Step 3: Reload Composer autoload**

```bash
composer dump-autoload
```

- [ ] **Step 4: Commit**

```bash
git add src/config/app.php src/lib/helpers.php
git commit -m "feat: add app config and global helper functions"
```

---

### Task 8: Database config

**Files:**
- Create: `src/config/db.php.example`
- Create: `src/config/db.php` (gitignored)

- [ ] **Step 1: Write `src/config/db.php.example`**

```php
<?php
return [
  'host'     => '127.0.0.1',
  'port'     => 3306,
  'database' => 'loansathi',
  'username' => 'root',
  'password' => '',
  'charset'  => 'utf8mb4',
];
```

- [ ] **Step 2: Copy to active config**

```bash
cp src/config/db.php.example src/config/db.php
```

(Leave defaults; XAMPP root has empty password locally.)

- [ ] **Step 3: Verify gitignore covers it**

```bash
git status --ignored src/config/
```

Expected: `src/config/db.php` appears under "Ignored files".

- [ ] **Step 4: Commit**

```bash
git add src/config/db.php.example
git commit -m "feat: add DB config example template"
```

---

### Task 9: PDO singleton

**Files:**
- Create: `src/lib/db.php`

- [ ] **Step 1: Write `src/lib/db.php`**

```php
<?php

function db(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $cfgPath = __DIR__ . '/../config/db.php';
    if (!file_exists($cfgPath)) {
        throw new RuntimeException('Missing src/config/db.php. Copy db.php.example and configure.');
    }
    $c = require $cfgPath;
    $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['database']};charset={$c['charset']}";
    $pdo = new PDO($dsn, $c['username'], $c['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}
```

- [ ] **Step 2: Commit**

```bash
git add src/lib/db.php
git commit -m "feat: add PDO singleton with strict error mode"
```

---

### Task 10: Install script (DB schema)

**Files:**
- Create: `bin/install.php`

- [ ] **Step 1: Write `bin/install.php`**

```php
<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/db.php';

$cfg = require __DIR__ . '/../src/config/db.php';

// Create database if missing
$rootPdo = new PDO(
    "mysql:host={$cfg['host']};port={$cfg['port']};charset={$cfg['charset']}",
    $cfg['username'], $cfg['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
$rootPdo->exec("CREATE DATABASE IF NOT EXISTS `{$cfg['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

$pdo = db();

$schema = <<<SQL
CREATE TABLE IF NOT EXISTS leads (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(180),
  loan_type VARCHAR(40) NOT NULL,
  loan_amount DECIMAL(14,2),
  city VARCHAR(80),
  monthly_income DECIMAL(12,2),
  employment_type VARCHAR(40),
  credit_score_range VARCHAR(20),
  message TEXT,
  source_page VARCHAR(255),
  source_form VARCHAR(40),
  utm_source VARCHAR(80),
  utm_medium VARCHAR(80),
  utm_campaign VARCHAR(120),
  ip_address VARCHAR(45),
  user_agent VARCHAR(255),
  status ENUM('new','contacted','qualified','disbursed','rejected','spam') DEFAULT 'new',
  admin_notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_created (created_at),
  INDEX idx_loan_type (loan_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(60) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(120),
  role ENUM('admin','editor') DEFAULT 'admin',
  last_login_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(200) UNIQUE NOT NULL,
  title VARCHAR(200) NOT NULL,
  excerpt VARCHAR(300),
  body MEDIUMTEXT NOT NULL,
  cover_image VARCHAR(255),
  category VARCHAR(40),
  meta_title VARCHAR(70),
  meta_description VARCHAR(170),
  status ENUM('draft','published') DEFAULT 'draft',
  published_at TIMESTAMP NULL,
  author_id INT UNSIGNED,
  view_count INT UNSIGNED DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES admin_users(id) ON DELETE SET NULL,
  INDEX idx_status_pub (status, published_at),
  INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS rate_limit_log (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ip_address VARCHAR(45) NOT NULL,
  event_type ENUM('form_submit','login_fail') NOT NULL,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ip_type_time (ip_address, event_type, submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;

foreach (explode(';', $schema) as $stmt) {
    $stmt = trim($stmt);
    if ($stmt !== '') $pdo->exec($stmt);
}

echo "Schema applied.\n";

// Seed first admin if none exists
$count = (int)$pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
if ($count === 0) {
    echo "No admin user exists. Create one now? (y/n): ";
    $ans = trim(fgets(STDIN));
    if (strtolower($ans) === 'y') {
        echo "Username: ";        $u = trim(fgets(STDIN));
        echo "Full name: ";       $n = trim(fgets(STDIN));
        echo "Password: ";        $p = trim(fgets(STDIN));
        $hash = password_hash($p, PASSWORD_BCRYPT);
        $pdo->prepare("INSERT INTO admin_users(username, password_hash, full_name) VALUES(?,?,?)")
            ->execute([$u, $hash, $n]);
        echo "Admin '{$u}' created.\n";
    }
}

echo "Install complete.\n";
```

- [ ] **Step 2: Make sure XAMPP MySQL is running**

Start XAMPP control panel manually if not running.

- [ ] **Step 3: Run install**

```bash
php bin/install.php
```

Expected: `Schema applied.` then admin-creation prompt. Type `y`, enter username `admin`, full name, and a strong password. Final line: `Install complete.`

- [ ] **Step 4: Verify schema in MySQL**

```bash
php -r "require 'src/lib/db.php'; \$r = db()->query('SHOW TABLES'); foreach (\$r as \$row) echo array_values(\$row)[0].PHP_EOL;"
```

Expected output:
```
admin_users
leads
posts
rate_limit_log
```

- [ ] **Step 5: Commit**

```bash
git add bin/install.php
git commit -m "feat: add install script with schema and admin seed"
```

---

### Task 11: Configure PHPUnit

**Files:**
- Create: `phpunit.xml`

- [ ] **Step 1: Write `phpunit.xml`**

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         cacheDirectory=".phpunit.result.cache">
  <testsuites>
    <testsuite name="unit">
      <directory>tests/unit</directory>
    </testsuite>
    <testsuite name="integration">
      <directory>tests/integration</directory>
    </testsuite>
  </testsuites>
  <php>
    <env name="APP_ENV" value="testing"/>
  </php>
</phpunit>
```

- [ ] **Step 2: Verify**

```bash
vendor/bin/phpunit --version
```

Expected: PHPUnit 10.x version line.

- [ ] **Step 3: Commit**

```bash
git add phpunit.xml
git commit -m "chore: add PHPUnit config"
```

---

## Phase C — Front Controller & Router

### Task 12: Front controller skeleton

**Files:**
- Create: `public/index.php`

- [ ] **Step 1: Write minimal `public/index.php`**

```php
<?php
// Front controller. All non-asset requests route through here via .htaccess.

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/lib/router.php';

// Strict error mode in dev; silent in prod
$isProd = (getenv('APP_ENV') === 'production');
error_reporting(E_ALL);
ini_set('display_errors', $isProd ? '0' : '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/php-error-' . date('Y-m-d') . '.log');

// Secure session defaults
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
if (($_SERVER['HTTPS'] ?? '') === 'on') {
    ini_set('session.cookie_secure', '1');
}
session_start();

try {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    route($path);
} catch (Throwable $ex) {
    error_log('[uncaught] ' . $ex->getMessage() . "\n" . $ex->getTraceAsString());
    http_response_code(500);
    if ($isProd) {
        require __DIR__ . '/../src/pages/500.php';
    } else {
        echo '<pre>' . htmlspecialchars((string)$ex) . '</pre>';
    }
    exit;
}
```

- [ ] **Step 2: Create stub `src/pages/500.php`**

```bash
cat > src/pages/500.php <<'EOF'
<?php http_response_code(500); ?>
<!doctype html><html lang="en-IN"><head><meta charset="utf-8"><title>Server error</title></head>
<body><h1>Something went wrong</h1><p>Please try again in a moment.</p></body></html>
EOF
```

- [ ] **Step 3: Commit**

```bash
git add public/index.php src/pages/500.php
git commit -m "feat: add front controller with secure session defaults and error logging"
```

---

### Task 13: .htaccess + robots.txt

**Files:**
- Create: `public/.htaccess`
- Create: `public/robots.txt`

- [ ] **Step 1: Write `public/.htaccess`**

```apache
# Rewrite all non-existent files/dirs to index.php
RewriteEngine On
RewriteBase /

# Block sensitive dirs (defense in depth — they're outside web root anyway)
RewriteRule ^(\.git|src|content|storage|bin|tests|vendor|node_modules)/ - [F,L]

# Skip rewrite for real files and directories
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

# Everything else → index.php
RewriteRule ^ index.php [QSA,L]

# Security headers
<IfModule mod_headers.c>
  Header set X-Content-Type-Options "nosniff"
  Header set X-Frame-Options "SAMEORIGIN"
  Header set Referrer-Policy "strict-origin-when-cross-origin"
  # Permissive CSP for Alpine.js CDN + future GA. Tighten in prod.
  Header set Content-Security-Policy "default-src 'self'; script-src 'self' 'unsafe-inline' https://unpkg.com https://www.googletagmanager.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self'; frame-ancestors 'self';"
</IfModule>

# Hide PHP version
<IfModule mod_headers.c>
  Header unset X-Powered-By
</IfModule>

# Cache static assets aggressively
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType text/css "access plus 30 days"
  ExpiresByType application/javascript "access plus 30 days"
  ExpiresByType image/svg+xml "access plus 30 days"
  ExpiresByType image/webp "access plus 30 days"
  ExpiresByType image/png "access plus 30 days"
  ExpiresByType image/jpeg "access plus 30 days"
</IfModule>

# Force UTF-8
AddDefaultCharset UTF-8
```

- [ ] **Step 2: Write `public/robots.txt`**

```
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /submit-lead
Disallow: /*?utm_*
Disallow: /*?preview=

Sitemap: https://loansathi.in/sitemap.xml
```

- [ ] **Step 3: Commit**

```bash
git add public/.htaccess public/robots.txt
git commit -m "feat: add .htaccess rewrites/security headers and robots.txt"
```

---

### Task 14: Router test (TDD)

**Files:**
- Create: `tests/unit/RouterTest.php`

- [ ] **Step 1: Write failing test**

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/router.php';

class RouterTest extends TestCase
{
    public function test_matches_static_route(): void
    {
        $routes = ['/' => 'home', '/about' => 'about'];
        $this->assertSame(['page' => 'home', 'params' => []], match_route('/', $routes));
        $this->assertSame(['page' => 'about', 'params' => []], match_route('/about', $routes));
    }

    public function test_matches_dynamic_route(): void
    {
        $routes = ['/blog/{slug}' => 'blog-post'];
        $result = match_route('/blog/hello-world', $routes);
        $this->assertSame('blog-post', $result['page']);
        $this->assertSame(['slug' => 'hello-world'], $result['params']);
    }

    public function test_returns_null_on_no_match(): void
    {
        $routes = ['/' => 'home'];
        $this->assertNull(match_route('/nope', $routes));
    }

    public function test_strips_trailing_slash(): void
    {
        $routes = ['/about' => 'about'];
        $this->assertSame('about', match_route('/about/', $routes)['page']);
    }

    public function test_multiple_params(): void
    {
        $routes = ['/admin/posts/{id}/edit' => 'admin/post-edit'];
        $result = match_route('/admin/posts/42/edit', $routes);
        $this->assertSame('admin/post-edit', $result['page']);
        $this->assertSame(['id' => '42'], $result['params']);
    }
}
```

- [ ] **Step 2: Run test, expect failure**

```bash
vendor/bin/phpunit tests/unit/RouterTest.php
```

Expected: errors / failures because `match_route` and `route` don't exist yet.

- [ ] **Step 3: Commit (test only)**

```bash
git add tests/unit/RouterTest.php
git commit -m "test: add router unit tests (failing)"
```

---

### Task 15: Implement router

**Files:**
- Create: `src/lib/router.php`

- [ ] **Step 1: Write `src/lib/router.php`**

```php
<?php

function routes_table(): array {
    return [
        '/'                 => 'home',
        '/submit-lead'      => 'handlers/submit-lead',
        '/thank-you'        => 'thank-you',
        // (more routes added in Plans 2-4)
    ];
}

/**
 * Match a path against a routes table.
 * Returns ['page' => '...', 'params' => [...]] or null.
 */
function match_route(string $path, array $routes): ?array {
    // Normalize: collapse multiple slashes, strip trailing slash (except root)
    $path = '/' . trim(preg_replace('#/+#', '/', $path), '/');
    if ($path === '/' && isset($routes['/'])) {
        return ['page' => $routes['/'], 'params' => []];
    }

    foreach ($routes as $pattern => $page) {
        if ($pattern === '/') continue;
        // Convert /blog/{slug} to regex
        $regex = '#^' . preg_replace('#\{([a-z_]+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
        if (preg_match($regex, $path, $m)) {
            $params = [];
            foreach ($m as $k => $v) {
                if (!is_int($k)) $params[$k] = $v;
            }
            return ['page' => $page, 'params' => $params];
        }
    }
    return null;
}

/**
 * Dispatch the request.
 */
function route(string $path): void {
    $match = match_route($path, routes_table());
    if ($match === null) {
        http_response_code(404);
        require __DIR__ . '/../pages/404.php';
        return;
    }
    $GLOBALS['route_params'] = $match['params'];
    $page = $match['page'];
    // Handlers live in src/handlers/ ; everything else in src/pages/
    $subdir = str_starts_with($page, 'handlers/') ? '' : 'pages/';
    $file = __DIR__ . '/../' . $subdir . $page . '.php';
    if (!file_exists($file)) {
        http_response_code(404);
        require __DIR__ . '/../pages/404.php';
        return;
    }
    require $file;
}
```

- [ ] **Step 2: Run tests, expect pass**

```bash
vendor/bin/phpunit tests/unit/RouterTest.php
```

Expected: `OK (5 tests, ...)`.

- [ ] **Step 3: Commit**

```bash
git add src/lib/router.php
git commit -m "feat: implement custom router with dynamic parameter support"
```

---

## Phase D — Security & Validation Libraries

### Task 16: CSRF test (TDD)

**Files:**
- Create: `tests/unit/CsrfTest.php`

- [ ] **Step 1: Write failing test**

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/csrf.php';

class CsrfTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = [];
    }

    public function test_token_is_generated_once_per_session(): void
    {
        $t1 = csrf_token();
        $t2 = csrf_token();
        $this->assertSame($t1, $t2);
        $this->assertSame(64, strlen($t1)); // 32 bytes hex
    }

    public function test_validate_accepts_matching_token(): void
    {
        $t = csrf_token();
        $this->assertTrue(csrf_validate($t));
    }

    public function test_validate_rejects_wrong_token(): void
    {
        csrf_token();
        $this->assertFalse(csrf_validate('deadbeef'));
    }

    public function test_validate_rejects_missing_token(): void
    {
        $this->assertFalse(csrf_validate(''));
    }
}
```

- [ ] **Step 2: Run, expect failure**

```bash
vendor/bin/phpunit tests/unit/CsrfTest.php
```

Expected: errors — `csrf.php` doesn't exist.

- [ ] **Step 3: Commit**

```bash
git add tests/unit/CsrfTest.php
git commit -m "test: add CSRF unit tests (failing)"
```

---

### Task 17: Implement CSRF

**Files:**
- Create: `src/lib/csrf.php`

- [ ] **Step 1: Write `src/lib/csrf.php`**

```php
<?php

function csrf_token(): string {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function csrf_validate(string $submitted): bool {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['_csrf']) || $submitted === '') return false;
    return hash_equals($_SESSION['_csrf'], $submitted);
}

function csrf_field(): string {
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES) . '">';
}
```

- [ ] **Step 2: Run tests**

```bash
vendor/bin/phpunit tests/unit/CsrfTest.php
```

Expected: `OK (4 tests, ...)`.

- [ ] **Step 3: Commit**

```bash
git add src/lib/csrf.php
git commit -m "feat: implement CSRF token helpers with timing-safe comparison"
```

---

### Task 18: Validator test (TDD)

**Files:**
- Create: `tests/unit/ValidatorTest.php`

- [ ] **Step 1: Write failing test**

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/validator.php';

class ValidatorTest extends TestCase
{
    public function test_valid_indian_phone_10_digits(): void
    {
        $this->assertTrue(is_valid_phone('9876543210'));
    }

    public function test_valid_indian_phone_with_country_code(): void
    {
        $this->assertTrue(is_valid_phone('+919876543210'));
        $this->assertTrue(is_valid_phone('919876543210'));
    }

    public function test_invalid_phone_too_short(): void
    {
        $this->assertFalse(is_valid_phone('12345'));
    }

    public function test_invalid_phone_letters(): void
    {
        $this->assertFalse(is_valid_phone('abc1234567'));
    }

    public function test_valid_email(): void
    {
        $this->assertTrue(is_valid_email('foo@example.in'));
    }

    public function test_invalid_email(): void
    {
        $this->assertFalse(is_valid_email('not-an-email'));
    }

    public function test_empty_email_is_invalid(): void
    {
        $this->assertFalse(is_valid_email(''));
    }

    public function test_valid_name(): void
    {
        $this->assertTrue(is_valid_name('Aman Kumar'));
        $this->assertTrue(is_valid_name("D'Souza"));
    }

    public function test_invalid_name_too_short(): void
    {
        $this->assertFalse(is_valid_name('A'));
    }

    public function test_invalid_name_numbers_only(): void
    {
        $this->assertFalse(is_valid_name('1234'));
    }

    public function test_validate_lead_payload_happy_path(): void
    {
        $data = [
            'name'      => 'Aman Kumar',
            'phone'     => '9876543210',
            'email'     => 'aman@example.in',
            'loan_type' => 'personal',
            'loan_amount' => 500000,
        ];
        $r = validate_lead($data);
        $this->assertTrue($r['ok']);
        $this->assertSame('Aman Kumar', $r['data']['name']);
    }

    public function test_validate_lead_payload_missing_required(): void
    {
        $r = validate_lead(['name' => '', 'phone' => '', 'loan_type' => '']);
        $this->assertFalse($r['ok']);
        $this->assertArrayHasKey('name', $r['errors']);
        $this->assertArrayHasKey('phone', $r['errors']);
        $this->assertArrayHasKey('loan_type', $r['errors']);
    }

    public function test_validate_lead_payload_rejects_bad_loan_type(): void
    {
        $r = validate_lead([
            'name' => 'X X', 'phone' => '9876543210', 'loan_type' => 'mortgage_garbage',
        ]);
        $this->assertFalse($r['ok']);
        $this->assertArrayHasKey('loan_type', $r['errors']);
    }
}
```

- [ ] **Step 2: Run, expect failure**

```bash
vendor/bin/phpunit tests/unit/ValidatorTest.php
```

Expected: errors — `validator.php` doesn't exist.

- [ ] **Step 3: Commit**

```bash
git add tests/unit/ValidatorTest.php
git commit -m "test: add validator unit tests (failing)"
```

---

### Task 19: Implement validator

**Files:**
- Create: `src/lib/validator.php`

- [ ] **Step 1: Write `src/lib/validator.php`**

```php
<?php

function is_valid_phone(string $phone): bool {
    // Accept: 10 digits, optional +91 / 91 prefix
    $digits = preg_replace('/\D/', '', $phone);
    if (str_starts_with($digits, '91') && strlen($digits) === 12) {
        $digits = substr($digits, 2);
    }
    return (bool)preg_match('/^[6-9]\d{9}$/', $digits);
}

function is_valid_email(string $email): bool {
    if ($email === '') return false;
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function is_valid_name(string $name): bool {
    $name = trim($name);
    if (strlen($name) < 2 || strlen($name) > 120) return false;
    // Must contain at least one letter
    return (bool)preg_match("/[A-Za-z\x{0900}-\x{097F}]/u", $name);
}

function validate_lead(array $data): array {
    $errors = [];
    $cfg = require __DIR__ . '/../config/app.php';
    $allowed_loan_types = array_keys($cfg['loan_types']);

    $name = trim($data['name'] ?? '');
    if (!is_valid_name($name))   $errors['name']  = 'Please enter your full name.';

    $phone = trim($data['phone'] ?? '');
    if (!is_valid_phone($phone)) $errors['phone'] = 'Please enter a valid 10-digit Indian mobile number.';

    $email = trim($data['email'] ?? '');
    if ($email !== '' && !is_valid_email($email)) $errors['email'] = 'Email looks invalid.';

    $loan_type = trim($data['loan_type'] ?? '');
    if (!in_array($loan_type, $allowed_loan_types, true)) {
        $errors['loan_type'] = 'Please pick a loan type.';
    }

    $loan_amount = $data['loan_amount'] ?? null;
    if ($loan_amount !== null && $loan_amount !== '') {
        if (!is_numeric($loan_amount) || (float)$loan_amount < 0) {
            $errors['loan_amount'] = 'Enter a positive amount.';
        } else {
            $loan_amount = (float)$loan_amount;
        }
    } else {
        $loan_amount = null;
    }

    if (!empty($errors)) return ['ok' => false, 'errors' => $errors];

    return ['ok' => true, 'data' => [
        'name'        => $name,
        'phone'       => $phone,
        'email'       => $email !== '' ? $email : null,
        'loan_type'   => $loan_type,
        'loan_amount' => $loan_amount,
        'city'        => trim($data['city'] ?? '') ?: null,
        'message'     => trim($data['message'] ?? '') ?: null,
        'source_form' => trim($data['source_form'] ?? '') ?: 'lead-form',
    ]];
}
```

- [ ] **Step 2: Run tests**

```bash
vendor/bin/phpunit tests/unit/ValidatorTest.php
```

Expected: `OK (13 tests, ...)`.

- [ ] **Step 3: Commit**

```bash
git add src/lib/validator.php
git commit -m "feat: implement validator with Indian phone format and lead payload validation"
```

---

### Task 20: Mailer wrapper

**Files:**
- Create: `src/lib/mailer.php`

- [ ] **Step 1: Write `src/lib/mailer.php`**

```php
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

/**
 * Send an email via SMTP. Returns true on success, false on failure (and logs).
 */
function send_mail(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
    $cfg = config('smtp');
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = $cfg['host'];
        $mail->Port       = $cfg['port'];
        if ($cfg['username'] !== '') {
            $mail->SMTPAuth = true;
            $mail->Username = $cfg['username'];
            $mail->Password = $cfg['password'];
        }
        if ($cfg['secure'] === 'tls') $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        if ($cfg['secure'] === 'ssl') $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mail->setFrom($cfg['from_address'], $cfg['from_name']);
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $htmlBody;
        $mail->AltBody = $textBody !== '' ? $textBody : strip_tags($htmlBody);

        $mail->send();
        return true;
    } catch (MailException $e) {
        error_log('[mailer] ' . $e->getMessage());
        return false;
    }
}
```

- [ ] **Step 2: Manual smoke (optional, requires SMTP creds)**

If you have SMTP creds, set env vars and run:
```bash
SMTP_HOST=smtp.example.com SMTP_USER=... SMTP_PASS=... SMTP_FROM=... \
php -r "require 'vendor/autoload.php'; require 'src/lib/helpers.php'; require 'src/lib/mailer.php'; var_dump(send_mail('you@example.com', 'Test', '<b>Hi</b>'));"
```
Expected: `bool(true)` and an email in your inbox. If SMTP isn't configured yet, skip this step.

- [ ] **Step 3: Commit**

```bash
git add src/lib/mailer.php
git commit -m "feat: add PHPMailer SMTP wrapper with error logging"
```

---

### Task 21: Rate-limit helper

**Files:**
- Create: `src/lib/rate_limit.php`

- [ ] **Step 1: Write `src/lib/rate_limit.php`**

```php
<?php

require_once __DIR__ . '/db.php';

/**
 * Check whether the IP has exceeded $limit events of $type in the last $windowSeconds.
 * Returns true if within limit (allowed), false if blocked.
 */
function rate_limit_check(string $ip, string $type, int $limit, int $windowSeconds): bool {
    $stmt = db()->prepare(
        "SELECT COUNT(*) FROM rate_limit_log
         WHERE ip_address = ? AND event_type = ?
           AND submitted_at >= (NOW() - INTERVAL ? SECOND)"
    );
    $stmt->execute([$ip, $type, $windowSeconds]);
    return ((int)$stmt->fetchColumn()) < $limit;
}

function rate_limit_record(string $ip, string $type): void {
    db()->prepare("INSERT INTO rate_limit_log(ip_address, event_type) VALUES(?, ?)")
        ->execute([$ip, $type]);
}

/**
 * Periodic cleanup: drop entries older than 7 days.
 */
function rate_limit_prune(): void {
    db()->exec("DELETE FROM rate_limit_log WHERE submitted_at < (NOW() - INTERVAL 7 DAY)");
}
```

- [ ] **Step 2: Commit**

```bash
git add src/lib/rate_limit.php
git commit -m "feat: add rate-limit helper backed by rate_limit_log"
```

---

### Task 22: Auth helpers

**Files:**
- Create: `src/lib/auth.php`

- [ ] **Step 1: Write `src/lib/auth.php`**

```php
<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/rate_limit.php';

function admin_user(): ?array {
    return $_SESSION['admin_user'] ?? null;
}

function admin_require_login(): void {
    if (admin_user() === null) {
        redirect('/admin/login');
    }
    // Idle timeout: 2 hours
    if (isset($_SESSION['admin_last_seen']) && (time() - $_SESSION['admin_last_seen']) > 7200) {
        admin_logout();
        redirect('/admin/login?expired=1');
    }
    $_SESSION['admin_last_seen'] = time();
}

function admin_attempt_login(string $username, string $password): bool {
    $ip = client_ip();
    if (!rate_limit_check($ip, 'login_fail', 5, 900)) {
        return false; // locked out
    }
    $stmt = db()->prepare("SELECT id, username, password_hash, full_name, role FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if (!$row || !password_verify($password, $row['password_hash'])) {
        rate_limit_record($ip, 'login_fail');
        return false;
    }
    session_regenerate_id(true);
    $_SESSION['admin_user'] = [
        'id'        => (int)$row['id'],
        'username'  => $row['username'],
        'full_name' => $row['full_name'],
        'role'      => $row['role'],
    ];
    $_SESSION['admin_last_seen'] = time();
    db()->prepare("UPDATE admin_users SET last_login_at = NOW() WHERE id = ?")
        ->execute([$row['id']]);
    return true;
}

function admin_logout(): void {
    unset($_SESSION['admin_user'], $_SESSION['admin_last_seen']);
    session_regenerate_id(true);
}

function admin_is_locked_out(): bool {
    return !rate_limit_check(client_ip(), 'login_fail', 5, 900);
}
```

- [ ] **Step 2: Commit**

```bash
git add src/lib/auth.php
git commit -m "feat: add admin auth with login throttling and idle timeout"
```

---

## Phase E — Calculator & Eligibility Libraries (TDD)

### Task 23: Calculator test

**Files:**
- Create: `tests/unit/CalculatorTest.php`

- [ ] **Step 1: Write failing test**

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/calculator.php';

class CalculatorTest extends TestCase
{
    public function test_emi_standard_case(): void
    {
        // ₹1,00,000 at 12% p.a. for 24 months → ~₹4,707.35
        $emi = calculate_emi(100000, 12, 24);
        $this->assertEqualsWithDelta(4707.35, $emi, 0.05);
    }

    public function test_emi_home_loan_case(): void
    {
        // ₹50,00,000 at 8.5% for 240 months (20 yr) → ~₹43,391
        $emi = calculate_emi(5000000, 8.5, 240);
        $this->assertEqualsWithDelta(43391, $emi, 1);
    }

    public function test_emi_zero_rate(): void
    {
        // Zero-interest: EMI = principal / tenure
        $emi = calculate_emi(120000, 0, 12);
        $this->assertEqualsWithDelta(10000, $emi, 0.01);
    }

    public function test_emi_one_month_tenure(): void
    {
        $emi = calculate_emi(10000, 12, 1);
        $this->assertEqualsWithDelta(10100, $emi, 1); // ~1% interest for the single month
    }

    public function test_emi_breakdown_totals(): void
    {
        $b = calculate_emi_breakdown(100000, 12, 24);
        $this->assertArrayHasKey('emi', $b);
        $this->assertArrayHasKey('total_interest', $b);
        $this->assertArrayHasKey('total_payment', $b);
        $this->assertEqualsWithDelta($b['total_payment'], $b['emi'] * 24, 0.5);
    }
}
```

- [ ] **Step 2: Run, expect failure**

```bash
vendor/bin/phpunit tests/unit/CalculatorTest.php
```

Expected: errors — `calculator.php` doesn't exist.

- [ ] **Step 3: Commit**

```bash
git add tests/unit/CalculatorTest.php
git commit -m "test: add EMI calculator unit tests (failing)"
```

---

### Task 24: Implement calculator

**Files:**
- Create: `src/lib/calculator.php`

- [ ] **Step 1: Write `src/lib/calculator.php`**

```php
<?php

/**
 * Standard EMI formula:
 * EMI = P * r * (1+r)^n / ((1+r)^n - 1)
 * where r = annual_rate / 12 / 100, n = tenure_months.
 *
 * Zero-rate special case: EMI = P / n.
 */
function calculate_emi(float $principal, float $annual_rate, int $tenure_months): float {
    if ($principal <= 0 || $tenure_months <= 0) return 0.0;
    if ($annual_rate == 0.0) return round($principal / $tenure_months, 2);

    $r = $annual_rate / 12 / 100;
    $pow = pow(1 + $r, $tenure_months);
    return round(($principal * $r * $pow) / ($pow - 1), 2);
}

function calculate_emi_breakdown(float $principal, float $annual_rate, int $tenure_months): array {
    $emi = calculate_emi($principal, $annual_rate, $tenure_months);
    $total_payment = round($emi * $tenure_months, 2);
    $total_interest = round($total_payment - $principal, 2);
    return [
        'emi'            => $emi,
        'principal'      => $principal,
        'total_interest' => $total_interest,
        'total_payment'  => $total_payment,
        'tenure_months'  => $tenure_months,
        'annual_rate'    => $annual_rate,
    ];
}

/**
 * Month-by-month amortization. Returns array of rows:
 * [['month'=>1,'emi'=>..,'interest'=>..,'principal'=>..,'balance'=>..], ...]
 */
function amortization_schedule(float $principal, float $annual_rate, int $tenure_months): array {
    $emi = calculate_emi($principal, $annual_rate, $tenure_months);
    $r = $annual_rate / 12 / 100;
    $balance = $principal;
    $rows = [];
    for ($m = 1; $m <= $tenure_months; $m++) {
        $interest = round($balance * $r, 2);
        $princ_part = round($emi - $interest, 2);
        $balance = round($balance - $princ_part, 2);
        if ($m === $tenure_months) {
            // Roll any rounding residue into the last principal payment.
            $princ_part = round($princ_part + $balance, 2);
            $balance = 0.0;
        }
        $rows[] = [
            'month'     => $m,
            'emi'       => $emi,
            'interest'  => $interest,
            'principal' => $princ_part,
            'balance'   => $balance,
        ];
    }
    return $rows;
}
```

- [ ] **Step 2: Run tests**

```bash
vendor/bin/phpunit tests/unit/CalculatorTest.php
```

Expected: `OK (5 tests, ...)`.

- [ ] **Step 3: Commit**

```bash
git add src/lib/calculator.php
git commit -m "feat: implement EMI calculator with zero-rate handling and amortization"
```

---

### Task 25: Eligibility test — personal loan

**Files:**
- Create: `tests/unit/EligibilityTest.php`

- [ ] **Step 1: Write failing test**

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/eligibility.php';

class EligibilityTest extends TestCase
{
    public function test_personal_loan_high_income(): void
    {
        // monthly_income=100000, existing_emi=10000 → 24*100000 - 12*10000 = 2,280,000
        $r = eligibility_personal(['desired' => 500000, 'monthly_income' => 100000, 'existing_emi' => 10000, 'age' => 35, 'credit_score' => 'good']);
        $this->assertTrue($r['eligible']);
        $this->assertSame(500000.0, $r['amount']); // capped at desired
    }

    public function test_personal_loan_low_score_ineligible(): void
    {
        $r = eligibility_personal(['desired' => 100000, 'monthly_income' => 50000, 'existing_emi' => 0, 'age' => 30, 'credit_score' => 'below_650']);
        $this->assertFalse($r['eligible']);
    }

    public function test_personal_loan_age_out_of_range(): void
    {
        $r = eligibility_personal(['desired' => 100000, 'monthly_income' => 100000, 'existing_emi' => 0, 'age' => 65, 'credit_score' => 'excellent']);
        $this->assertFalse($r['eligible']);
    }

    public function test_personal_loan_capped_by_capacity(): void
    {
        // Capacity: 24*30000 - 0 = 720,000
        $r = eligibility_personal(['desired' => 2000000, 'monthly_income' => 30000, 'existing_emi' => 0, 'age' => 30, 'credit_score' => 'good']);
        $this->assertTrue($r['eligible']);
        $this->assertSame(720000.0, $r['amount']);
    }
}
```

- [ ] **Step 2: Run, expect failure**

```bash
vendor/bin/phpunit tests/unit/EligibilityTest.php
```

Expected: errors — `eligibility.php` doesn't exist.

- [ ] **Step 3: Commit**

```bash
git add tests/unit/EligibilityTest.php
git commit -m "test: add eligibility tests for personal loan (failing)"
```

---

### Task 26: Implement eligibility — personal loan

**Files:**
- Create: `src/lib/eligibility.php`

- [ ] **Step 1: Write `src/lib/eligibility.php`**

```php
<?php

/**
 * Each eligibility function takes a profile array and returns:
 * ['eligible' => bool, 'amount' => float, 'reason' => ?string]
 */

function eligibility_personal(array $p): array {
    $desired = (float)($p['desired'] ?? 0);
    $income  = (float)($p['monthly_income'] ?? 0);
    $emi     = (float)($p['existing_emi'] ?? 0);
    $age     = (int)($p['age'] ?? 0);
    $score   = $p['credit_score'] ?? '';

    if ($age < 21 || $age > 60) {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Age must be between 21 and 60.'];
    }
    if ($score === 'below_650') {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'A credit score below 650 typically disqualifies a personal loan.'];
    }
    $capacity = (24 * $income) - (12 * $emi);
    if ($capacity <= 0) {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Existing EMIs exceed repayment capacity.'];
    }
    $amount = min($desired > 0 ? $desired : $capacity, $capacity);
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}
```

- [ ] **Step 2: Run tests**

```bash
vendor/bin/phpunit tests/unit/EligibilityTest.php
```

Expected: `OK (4 tests, ...)`.

- [ ] **Step 3: Commit**

```bash
git add src/lib/eligibility.php
git commit -m "feat: implement personal loan eligibility rule"
```

---

### Task 27: Eligibility tests + rules for remaining 6 loan types

**Files:**
- Modify: `tests/unit/EligibilityTest.php`
- Modify: `src/lib/eligibility.php`

- [ ] **Step 1: Append tests for home, business, gold, lap, education, vehicle**

Append to `tests/unit/EligibilityTest.php`:

```php
    public function test_home_loan_eligibility(): void
    {
        // monthly_income=80000, 55% capacity = 44000 EMI max
        // Back-calc principal at 8.5% / 240 months: ~5.1L per 1L of principal in EMI → ~₹50,67,000
        $r = eligibility_home(['desired' => 5000000, 'monthly_income' => 80000, 'existing_emi' => 0, 'rate' => 8.5, 'tenure_months' => 240]);
        $this->assertTrue($r['eligible']);
        $this->assertGreaterThan(4000000, $r['amount']);
    }

    public function test_business_loan_eligibility(): void
    {
        // 0.30 * 1,00,00,000 = ₹30,00,000
        $r = eligibility_business(['desired' => 5000000, 'annual_turnover' => 10000000]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(3000000.0, $r['amount']);
    }

    public function test_gold_loan_eligibility(): void
    {
        // 100g * ₹6,000 * 0.75 = ₹4,50,000
        $r = eligibility_gold(['desired' => 600000, 'gold_grams' => 100]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(450000.0, $r['amount']);
    }

    public function test_lap_eligibility(): void
    {
        // 0.65 * 1Cr = ₹65,00,000
        $r = eligibility_lap(['desired' => 8000000, 'property_value' => 10000000]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(6500000.0, $r['amount']);
    }

    public function test_education_loan_no_collateral_cap(): void
    {
        $r = eligibility_education(['desired' => 2000000, 'has_collateral' => false]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(750000.0, $r['amount']);
    }

    public function test_education_loan_with_collateral_higher_cap(): void
    {
        $r = eligibility_education(['desired' => 3000000, 'has_collateral' => true]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(3000000.0, $r['amount']);
    }

    public function test_vehicle_loan_eligibility(): void
    {
        // 0.85 * 8L = ₹6,80,000
        $r = eligibility_vehicle(['desired' => 700000, 'on_road_price' => 800000]);
        $this->assertTrue($r['eligible']);
        $this->assertSame(680000.0, $r['amount']);
    }
}
```

Note: remove the trailing `}` from the original file before appending (it's the class close brace). Append these methods inside the class, then re-close.

- [ ] **Step 2: Run tests, expect failure**

```bash
vendor/bin/phpunit tests/unit/EligibilityTest.php
```

Expected: errors for missing `eligibility_home`, etc.

- [ ] **Step 3: Append implementations to `src/lib/eligibility.php`**

```php

function eligibility_home(array $p): array {
    $income = (float)($p['monthly_income'] ?? 0);
    $emi    = (float)($p['existing_emi'] ?? 0);
    $rate   = (float)($p['rate'] ?? 8.5);
    $n      = (int)($p['tenure_months'] ?? 240);
    $desired = (float)($p['desired'] ?? 0);

    $ratio = config('eligibility.home_max_emi_ratio');
    $max_emi = ($income * $ratio) - $emi;
    if ($max_emi <= 0) {
        return ['eligible' => false, 'amount' => 0.0, 'reason' => 'No EMI headroom.'];
    }
    // Back-calc principal from EMI: P = EMI * ((1+r)^n - 1) / (r * (1+r)^n)
    $r = $rate / 12 / 100;
    if ($r == 0.0) {
        $principal = $max_emi * $n;
    } else {
        $pow = pow(1 + $r, $n);
        $principal = $max_emi * ($pow - 1) / ($r * $pow);
    }
    $amount = $desired > 0 ? min($principal, $desired) : $principal;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_business(array $p): array {
    $turnover = (float)($p['annual_turnover'] ?? 0);
    $desired  = (float)($p['desired'] ?? 0);
    $mult = config('eligibility.business_multiplier');
    if ($turnover <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Annual turnover required.'];
    $cap = $turnover * $mult;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_gold(array $p): array {
    $grams = (float)($p['gold_grams'] ?? 0);
    $desired = (float)($p['desired'] ?? 0);
    $rate = config('eligibility.gold_rate_per_gram');
    $ltv  = config('eligibility.gold_ltv');
    if ($grams <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Gold weight required.'];
    $cap = $grams * $rate * $ltv;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_lap(array $p): array {
    $val = (float)($p['property_value'] ?? 0);
    $desired = (float)($p['desired'] ?? 0);
    $ltv = config('eligibility.lap_ltv');
    if ($val <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Property value required.'];
    $cap = $val * $ltv;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}

function eligibility_education(array $p): array {
    $hasCol  = (bool)($p['has_collateral'] ?? false);
    $desired = (float)($p['desired'] ?? 0);
    $cap = $hasCol
        ? config('eligibility.edu_with_collateral_cap')
        : config('eligibility.edu_no_collateral_cap');
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => (float)round($amount, 2), 'reason' => null];
}

function eligibility_vehicle(array $p): array {
    $price = (float)($p['on_road_price'] ?? 0);
    $desired = (float)($p['desired'] ?? 0);
    $ltv = config('eligibility.vehicle_ltv');
    if ($price <= 0) return ['eligible' => false, 'amount' => 0.0, 'reason' => 'Vehicle price required.'];
    $cap = $price * $ltv;
    $amount = $desired > 0 ? min($cap, $desired) : $cap;
    return ['eligible' => true, 'amount' => round($amount, 2), 'reason' => null];
}
```

- [ ] **Step 4: Run tests, expect pass**

```bash
vendor/bin/phpunit tests/unit/EligibilityTest.php
```

Expected: `OK (11 tests, ...)`.

- [ ] **Step 5: Commit**

```bash
git add src/lib/eligibility.php tests/unit/EligibilityTest.php
git commit -m "feat: implement eligibility rules for home, business, gold, LAP, education, vehicle"
```

---

## Phase F — Partials & Layout

### Task 28: SEO meta partial

**Files:**
- Create: `src/partials/seo-meta.php`
- Create: `src/lib/seo.php`

- [ ] **Step 1: Write `src/lib/seo.php`**

```php
<?php

/**
 * Build the Organization JSON-LD (site-wide).
 */
function ld_organization(): array {
    return [
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        'name'     => config('site_name'),
        'url'      => config('base_url'),
        'logo'     => asset('images/logo.svg'),
        'contactPoint' => [[
            '@type'         => 'ContactPoint',
            'telephone'     => config('contact.phone'),
            'contactType'   => 'customer service',
            'areaServed'    => 'IN',
            'availableLanguage' => ['English', 'Hindi'],
        ]],
    ];
}

function ld_breadcrumbs(array $crumbs): array {
    $items = [];
    foreach ($crumbs as $i => $c) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $c['name'],
            'item'     => $c['url'],
        ];
    }
    return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

function render_json_ld(array ...$schemas): string {
    $out = '';
    foreach ($schemas as $s) {
        $out .= '<script type="application/ld+json">' . json_encode($s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    return $out;
}
```

- [ ] **Step 2: Write `src/partials/seo-meta.php`**

```php
<?php
// Expected variables (caller sets before include):
// $page_title (string, ~60 chars)
// $page_description (string, ~155 chars)
// $page_canonical (string, full URL) — optional, defaults to current URL
// $page_og_image (string, full URL) — optional
// $page_robots (string) — optional, default 'index,follow'
// $page_json_ld (array of arrays) — optional, extra JSON-LD beyond Organization

$title       = $page_title       ?? config('site_name') . ' — ' . config('tagline');
$description = $page_description ?? 'Compare loan offers, calculate EMI, and get expert guidance — all in one place.';
$canonical   = $page_canonical   ?? base_url($_SERVER['REQUEST_URI'] ?? '/');
$ogImage     = $page_og_image    ?? asset('images/og-default.png');
$robots      = $page_robots      ?? 'index,follow';
$extraLd     = $page_json_ld     ?? [];
?>
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($description) ?>">
<meta name="robots" content="<?= e($robots) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e(config('site_name')) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($description) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($title) ?>">
<meta name="twitter:description" content="<?= e($description) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<?php if ($gsc = config('gsc_verification')): ?>
  <meta name="google-site-verification" content="<?= e($gsc) ?>">
<?php endif; ?>
<?php if ($bing = config('bing_verification')): ?>
  <meta name="msvalidate.01" content="<?= e($bing) ?>">
<?php endif; ?>

<?= render_json_ld(ld_organization(), ...$extraLd) ?>
```

- [ ] **Step 3: Commit**

```bash
git add src/lib/seo.php src/partials/seo-meta.php
git commit -m "feat: add SEO meta partial and JSON-LD schema builders"
```

---

### Task 29: Header partial

**Files:**
- Create: `src/partials/header.php`

- [ ] **Step 1: Write `src/partials/header.php`**

```php
<?php
// Expects optionally: $page_title, $page_description, etc. (for seo-meta.php)
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/seo.php';
require_once __DIR__ . '/../lib/csrf.php';

$phone     = config('contact.phone');
$phone_ui  = config('contact.phone_display');
$whatsapp  = config('contact.whatsapp');
?>
<!doctype html>
<html lang="en-IN">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset('css/site.css') ?>">
  <script defer src="https://unpkg.com/alpinejs@3.13.0/dist/cdn.min.js"></script>
  <?php require __DIR__ . '/seo-meta.php'; ?>
</head>
<body class="min-h-screen flex flex-col bg-white">
<header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
  <div class="container-page flex items-center justify-between h-16">
    <a href="/" class="flex items-baseline gap-1 text-xl font-extrabold text-navy">
      <span>Loan</span><span class="text-brand-amber">Sathi</span>
    </a>
    <nav class="hidden md:flex items-center gap-1" x-data="{open:''}">
      <a href="/personal-loan" class="btn-ghost">Loans</a>
      <a href="/emi-calculator" class="btn-ghost">Tools</a>
      <a href="/blog" class="btn-ghost">Blog</a>
      <a href="/about" class="btn-ghost">About</a>
      <a href="/contact" class="btn-ghost">Contact</a>
    </nav>
    <div class="flex items-center gap-2">
      <a href="tel:<?= e($phone) ?>" class="hidden sm:inline text-sm font-semibold text-navy"><?= e($phone_ui) ?></a>
      <a href="#lead-form" class="btn-primary text-sm py-2 px-4">Apply Now</a>
    </div>
  </div>
</header>
<main class="flex-1">
```

- [ ] **Step 2: Commit**

```bash
git add src/partials/header.php
git commit -m "feat: add site header partial with sticky nav and Manrope font"
```

---

### Task 30: Footer partial

**Files:**
- Create: `src/partials/footer.php`

- [ ] **Step 1: Write `src/partials/footer.php`**

```php
<?php
$loan_types = config('loan_types');
$phone_ui   = config('contact.phone_display');
$email      = config('contact.email');
?>
</main>
<?php require __DIR__ . '/whatsapp-fab.php'; ?>
<?php require __DIR__ . '/cookie-banner.php'; ?>

<footer class="mt-16 bg-navy text-slate-200">
  <div class="container-page py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-sm">
    <div>
      <div class="text-white text-xl font-extrabold mb-3">Loan<span class="text-brand-amber">Sathi</span></div>
      <p class="text-slate-300/80 text-sm leading-relaxed">Your trusted loan companion — comparing lenders so you don't have to.</p>
      <p class="text-slate-400 text-xs mt-4">Call: <a class="text-white" href="tel:<?= e(config('contact.phone')) ?>"><?= e($phone_ui) ?></a></p>
      <p class="text-slate-400 text-xs">Email: <a class="text-white" href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
    </div>
    <div>
      <div class="text-white font-bold mb-3">Loans</div>
      <ul class="space-y-2">
        <?php foreach ($loan_types as $slug => $label): ?>
          <li><a class="hover:text-white" href="/<?= e($slug === 'lap' ? 'loan-against-property' : $slug . '-loan') ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <div class="text-white font-bold mb-3">Tools</div>
      <ul class="space-y-2">
        <li><a class="hover:text-white" href="/emi-calculator">EMI Calculator</a></li>
        <li><a class="hover:text-white" href="/eligibility-checker">Eligibility Checker</a></li>
        <li><a class="hover:text-white" href="/loan-comparison">Loan Comparison</a></li>
        <li><a class="hover:text-white" href="/application-guide">Application Guide</a></li>
      </ul>
    </div>
    <div>
      <div class="text-white font-bold mb-3">Company</div>
      <ul class="space-y-2">
        <li><a class="hover:text-white" href="/about">About us</a></li>
        <li><a class="hover:text-white" href="/contact">Contact</a></li>
        <li><a class="hover:text-white" href="/blog">Blog</a></li>
        <li><a class="hover:text-white" href="/privacy-policy">Privacy Policy</a></li>
        <li><a class="hover:text-white" href="/terms-of-service">Terms</a></li>
        <li><a class="hover:text-white" href="/disclaimer">Disclaimer</a></li>
      </ul>
    </div>
  </div>
  <div class="border-t border-slate-700/60">
    <div class="container-page py-6 text-xs text-slate-400/80 leading-relaxed">
      LoanSathi is an independent loan advisory service. We do not lend money. Loan terms (rate, fees, eligibility) are determined solely by the lender. Indicative rates shown across the site are for educational purposes and may change without notice.
      <div class="mt-3">© <?= date('Y') ?> LoanSathi. All rights reserved.</div>
    </div>
  </div>
</footer>
</body>
</html>
```

- [ ] **Step 2: Commit**

```bash
git add src/partials/footer.php
git commit -m "feat: add site footer with link inventory and facilitator disclaimer"
```

---

### Task 31: WhatsApp FAB

**Files:**
- Create: `src/partials/whatsapp-fab.php`

- [ ] **Step 1: Write `src/partials/whatsapp-fab.php`**

```php
<?php
$num = config('contact.whatsapp');
$msg = $whatsapp_message ?? "Hi, I'm interested in a loan. Please call me back.";
$href = 'https://wa.me/' . urlencode($num) . '?text=' . urlencode($msg);
?>
<a href="<?= e($href) ?>"
   target="_blank"
   rel="noopener"
   aria-label="Chat with us on WhatsApp"
   class="fixed bottom-5 right-5 z-50 inline-flex items-center justify-center w-14 h-14 rounded-full bg-green-500 hover:bg-green-600 shadow-hero text-white">
  <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.634-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
  </svg>
</a>
```

- [ ] **Step 2: Commit**

```bash
git add src/partials/whatsapp-fab.php
git commit -m "feat: add floating WhatsApp button with customizable message"
```

---

### Task 32: Cookie banner + breadcrumbs partials

**Files:**
- Create: `src/partials/cookie-banner.php`
- Create: `src/partials/breadcrumbs.php`

- [ ] **Step 1: Write `src/partials/cookie-banner.php`**

```php
<div x-data="{shown: !localStorage.getItem('cookie_ok')}"
     x-show="shown"
     x-cloak
     class="fixed bottom-0 inset-x-0 z-40 bg-navy text-white">
  <div class="container-page py-4 flex flex-col sm:flex-row items-center gap-4 text-sm">
    <p class="flex-1">We use cookies to improve your experience and analyze site traffic. By continuing you agree to our <a class="underline" href="/privacy-policy">Privacy Policy</a>.</p>
    <button @click="localStorage.setItem('cookie_ok','1'); shown=false"
            class="btn-primary text-sm py-2 px-4 whitespace-nowrap">
      Got it
    </button>
  </div>
</div>
<style>[x-cloak]{display:none!important}</style>
```

- [ ] **Step 2: Write `src/partials/breadcrumbs.php`**

```php
<?php
// Expects: $breadcrumbs = [['name' => 'Home', 'url' => '/'], ['name' => '...', 'url' => '...']];
$crumbs = $breadcrumbs ?? [];
if (!$crumbs) return;
?>
<nav aria-label="Breadcrumb" class="container-page text-sm text-slate-500 py-4">
  <ol class="flex flex-wrap gap-1">
    <?php foreach ($crumbs as $i => $c): ?>
      <li>
        <?php if ($i === count($crumbs) - 1): ?>
          <span class="text-navy font-semibold"><?= e($c['name']) ?></span>
        <?php else: ?>
          <a class="hover:text-navy" href="<?= e($c['url']) ?>"><?= e($c['name']) ?></a>
          <span class="mx-1 text-slate-400">/</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
```

- [ ] **Step 3: Commit**

```bash
git add src/partials/cookie-banner.php src/partials/breadcrumbs.php
git commit -m "feat: add cookie banner and breadcrumbs partials"
```

---

### Task 33: Lead form partial

**Files:**
- Create: `src/partials/lead-form.php`

- [ ] **Step 1: Write `src/partials/lead-form.php`**

```php
<?php
require_once __DIR__ . '/../lib/csrf.php';
$loan_types = config('loan_types');
// Caller may set: $lead_form_default_type, $lead_form_source, $lead_form_title
$defaultType = $lead_form_default_type ?? '';
$source      = $lead_form_source      ?? 'lead-form';
$title       = $lead_form_title       ?? 'Get a free callback in 24 hours';
?>
<div id="lead-form" class="bg-white rounded-2xl shadow-card p-6 sm:p-8"
     x-data="leadForm({source: '<?= e($source) ?>'})"
     x-init="init()">
  <h3 class="text-xl font-extrabold text-navy mb-1"><?= e($title) ?></h3>
  <p class="text-sm text-slate-500 mb-4">No fees from you — we get paid by the lender once your loan is disbursed.</p>

  <template x-if="status === 'success'">
    <div class="rounded-lg bg-green-50 border border-green-200 text-green-800 p-4 text-sm">
      <strong>Thanks!</strong> We'll be in touch within 24 hours. Or chat with us on
      <a class="underline font-semibold" target="_blank" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>">WhatsApp</a> for an instant reply.
    </div>
  </template>

  <form x-show="status !== 'success'" @submit.prevent="submit" class="space-y-3" novalidate>
    <?= csrf_field() ?>
    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

    <div>
      <input class="input-field" :class="{'error': errors.name}" type="text" name="name" placeholder="Your full name" x-model="form.name" required>
      <p class="error-text" x-text="errors.name" x-show="errors.name"></p>
    </div>
    <div>
      <input class="input-field" :class="{'error': errors.phone}" type="tel" inputmode="tel" name="phone" placeholder="Mobile number (10-digit)" x-model="form.phone" required>
      <p class="error-text" x-text="errors.phone" x-show="errors.phone"></p>
    </div>
    <div>
      <input class="input-field" :class="{'error': errors.email}" type="email" name="email" placeholder="Email (optional)" x-model="form.email">
      <p class="error-text" x-text="errors.email" x-show="errors.email"></p>
    </div>
    <div>
      <select class="input-field" :class="{'error': errors.loan_type}" name="loan_type" x-model="form.loan_type" required>
        <option value="">Select loan type</option>
        <?php foreach ($loan_types as $slug => $label): ?>
          <option value="<?= e($slug) ?>" <?= $defaultType === $slug ? 'selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
      <p class="error-text" x-text="errors.loan_type" x-show="errors.loan_type"></p>
    </div>
    <div>
      <input class="input-field" type="number" name="loan_amount" placeholder="Loan amount (₹, optional)" x-model="form.loan_amount" min="0">
    </div>
    <div>
      <input class="input-field" type="text" name="city" placeholder="Your city (optional)" x-model="form.city">
    </div>

    <button type="submit" class="btn-primary w-full" :disabled="status==='submitting'">
      <span x-show="status!=='submitting'">Request callback</span>
      <span x-show="status==='submitting'">Submitting...</span>
    </button>

    <template x-if="status === 'error'">
      <p class="text-sm text-red-600">Something went wrong. Please try again or call us at <?= e(config('contact.phone_display')) ?>.</p>
    </template>

    <p class="text-xs text-slate-500 text-center">By submitting, you agree to our <a class="underline" href="/privacy-policy">Privacy Policy</a>.</p>
  </form>
</div>

<script>
function leadForm(opts){
  return {
    status: 'idle',
    form: { name:'', phone:'', email:'', loan_type:'<?= e($defaultType) ?>', loan_amount:'', city:'', source_form: opts.source },
    errors: {},
    init() {},
    async submit() {
      this.status = 'submitting';
      this.errors = {};
      try {
        const res = await fetch('/submit-lead', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ ...this.form, _csrf: document.querySelector('#lead-form input[name=_csrf]').value, website: document.querySelector('#lead-form input[name=website]').value, source_page: location.pathname }),
        });
        const data = await res.json();
        if (res.ok && data.ok) {
          this.status = 'success';
          if (window.dataLayer) window.dataLayer.push({event:'lead_submit', loan_type:this.form.loan_type});
        } else {
          this.errors = data.errors || {};
          this.status = res.status === 429 ? 'error' : 'idle';
          if (res.status === 429) this.errors._all = 'Too many submissions. Please try later.';
        }
      } catch (e) {
        this.status = 'error';
      }
    }
  };
}
</script>
```

- [ ] **Step 2: Commit**

```bash
git add src/partials/lead-form.php
git commit -m "feat: add lead form partial with Alpine.js validation and CSRF/honeypot"
```

---

## Phase G — Lead Submission Handler

### Task 34: Submit-lead handler test (TDD)

**Files:**
- Create: `tests/unit/SubmitLeadTest.php`

- [ ] **Step 1: Write failing test**

This test exercises the validation/rate-limit logic via a function we'll expose, so we don't have to spin up a full HTTP server in unit tests. The handler script itself is exercised in a smoke test later.

```php
<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/lib/helpers.php';
require_once __DIR__ . '/../../src/lib/validator.php';
require_once __DIR__ . '/../../src/handlers/submit_lead_logic.php';

class SubmitLeadTest extends TestCase
{
    public function test_honeypot_drops_silently(): void
    {
        $r = process_lead_submission([
            'name' => 'A B', 'phone' => '9876543210', 'loan_type' => 'personal',
            'website' => 'http://spam.example',
            '_csrf' => 'token', 'session_csrf' => 'token',
        ], '127.0.0.1', 'UA');
        $this->assertTrue($r['ok']);
        $this->assertSame('honeypot', $r['note']);
    }

    public function test_bad_csrf_rejected(): void
    {
        $r = process_lead_submission([
            'name' => 'A B', 'phone' => '9876543210', 'loan_type' => 'personal',
            '_csrf' => 'one', 'session_csrf' => 'two',
        ], '127.0.0.1', 'UA');
        $this->assertFalse($r['ok']);
        $this->assertSame('csrf', $r['code']);
    }

    public function test_validation_errors_returned(): void
    {
        $r = process_lead_submission([
            'name' => '', 'phone' => 'bad', 'loan_type' => 'fake',
            '_csrf' => 'token', 'session_csrf' => 'token',
        ], '127.0.0.1', 'UA');
        $this->assertFalse($r['ok']);
        $this->assertSame('validation', $r['code']);
        $this->assertArrayHasKey('name', $r['errors']);
        $this->assertArrayHasKey('phone', $r['errors']);
        $this->assertArrayHasKey('loan_type', $r['errors']);
    }

    public function test_happy_path_returns_data(): void
    {
        $r = process_lead_submission([
            'name' => 'Aman Kumar', 'phone' => '9876543210', 'email' => 'a@b.in',
            'loan_type' => 'personal', 'loan_amount' => 500000,
            '_csrf' => 'token', 'session_csrf' => 'token',
        ], '127.0.0.1', 'UA');
        $this->assertTrue($r['ok']);
        $this->assertSame('Aman Kumar', $r['data']['name']);
    }
}
```

- [ ] **Step 2: Run, expect failure**

```bash
vendor/bin/phpunit tests/unit/SubmitLeadTest.php
```

Expected: errors — `submit_lead_logic.php` missing.

- [ ] **Step 3: Commit**

```bash
git add tests/unit/SubmitLeadTest.php
git commit -m "test: add submit-lead unit tests (failing)"
```

---

### Task 35: Implement lead submission logic

**Files:**
- Create: `src/handlers/submit_lead_logic.php`
- Create: `src/handlers/submit-lead.php`

- [ ] **Step 1: Write `src/handlers/submit_lead_logic.php`** (pure-function, DB-optional for testability)

```php
<?php

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/validator.php';

/**
 * Process a lead submission payload. Pure logic — DB is optional via $allow_storage flag.
 *
 * Returns:
 *   ['ok' => true, 'data' => [...]] on success (validated, ready-to-store payload)
 *   ['ok' => true, 'note' => 'honeypot'] when honeypot triggered (silent drop)
 *   ['ok' => false, 'code' => 'csrf'|'validation'|'rate_limit', 'errors' => [...]] on rejection
 */
function process_lead_submission(array $body, string $ip, string $ua): array {
    // Honeypot
    if (!empty($body['website'])) {
        return ['ok' => true, 'note' => 'honeypot'];
    }
    // CSRF
    $submitted = (string)($body['_csrf'] ?? '');
    $session   = (string)($body['session_csrf'] ?? $_SESSION['_csrf'] ?? '');
    if ($submitted === '' || $session === '' || !hash_equals($session, $submitted)) {
        return ['ok' => false, 'code' => 'csrf'];
    }
    // Validate
    $v = validate_lead($body);
    if (!$v['ok']) {
        return ['ok' => false, 'code' => 'validation', 'errors' => $v['errors']];
    }
    $data = $v['data'];
    $data['ip_address']   = $ip;
    $data['user_agent']   = mb_substr($ua, 0, 255);
    $data['source_page']  = mb_substr((string)($body['source_page'] ?? ''), 0, 255);
    $data['utm_source']   = mb_substr((string)($body['utm_source'] ?? ''), 0, 80);
    $data['utm_medium']   = mb_substr((string)($body['utm_medium'] ?? ''), 0, 80);
    $data['utm_campaign'] = mb_substr((string)($body['utm_campaign'] ?? ''), 0, 120);
    $data['monthly_income']     = isset($body['monthly_income']) && is_numeric($body['monthly_income']) ? (float)$body['monthly_income'] : null;
    $data['employment_type']    = mb_substr((string)($body['employment_type'] ?? ''), 0, 40) ?: null;
    $data['credit_score_range'] = mb_substr((string)($body['credit_score_range'] ?? ''), 0, 20) ?: null;
    return ['ok' => true, 'data' => $data];
}

function store_lead(array $data): int {
    require_once __DIR__ . '/../lib/db.php';
    $sql = "INSERT INTO leads
        (name, phone, email, loan_type, loan_amount, city, monthly_income, employment_type,
         credit_score_range, message, source_page, source_form, utm_source, utm_medium, utm_campaign,
         ip_address, user_agent)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = db()->prepare($sql);
    $stmt->execute([
        $data['name'], $data['phone'], $data['email'] ?? null, $data['loan_type'],
        $data['loan_amount'] ?? null, $data['city'] ?? null, $data['monthly_income'] ?? null,
        $data['employment_type'] ?? null, $data['credit_score_range'] ?? null,
        $data['message'] ?? null, $data['source_page'] ?? null, $data['source_form'] ?? null,
        $data['utm_source'] ?? null, $data['utm_medium'] ?? null, $data['utm_campaign'] ?? null,
        $data['ip_address'] ?? null, $data['user_agent'] ?? null,
    ]);
    return (int)db()->lastInsertId();
}

function notify_lead_email(array $data, int $leadId): bool {
    require_once __DIR__ . '/../lib/mailer.php';
    $to = config('contact.lead_inbox');
    $subject = '[LoanSathi] New lead: ' . $data['name'] . ' — ' . $data['loan_type'];
    $admin_url = config('base_url') . '/admin/leads/' . $leadId;
    $rows = '';
    foreach ($data as $k => $v) {
        $rows .= '<tr><td style="padding:4px 8px;border:1px solid #eee"><b>' . e($k) . '</b></td><td style="padding:4px 8px;border:1px solid #eee">' . e((string)$v) . '</td></tr>';
    }
    $html = "<h2>New lead #{$leadId}</h2>"
          . "<p>View in admin: <a href=\"" . e($admin_url) . "\">" . e($admin_url) . "</a></p>"
          . "<table style=\"border-collapse:collapse;font-family:sans-serif\">{$rows}</table>";
    return send_mail($to, $subject, $html);
}
```

- [ ] **Step 2: Write the HTTP handler `src/handlers/submit-lead.php`**

```php
<?php

require_once __DIR__ . '/../lib/csrf.php';
require_once __DIR__ . '/../lib/rate_limit.php';
require_once __DIR__ . '/submit_lead_logic.php';

header('Content-Type: application/json');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    json_response(['ok' => false, 'code' => 'method'], 405);
}

$raw = file_get_contents('php://input') ?: '';
$body = json_decode($raw, true) ?: [];
$body['session_csrf'] = $_SESSION['_csrf'] ?? '';

$ip = client_ip();
$ua = (string)($_SERVER['HTTP_USER_AGENT'] ?? '');

// Rate limit BEFORE doing work
if (!rate_limit_check($ip, 'form_submit', 5, 3600)) {
    json_response(['ok' => false, 'code' => 'rate_limit', 'message' => 'Too many submissions. Please try again later.'], 429);
}

$result = process_lead_submission($body, $ip, $ua);

if (!empty($result['note']) && $result['note'] === 'honeypot') {
    json_response(['ok' => true, 'message' => 'Thanks.']); // silent success
}

if (!$result['ok']) {
    $status = $result['code'] === 'csrf' ? 403 : 422;
    json_response($result, $status);
}

try {
    $leadId = store_lead($result['data']);
    rate_limit_record($ip, 'form_submit');
    // Best-effort email; failure doesn't fail the request
    notify_lead_email($result['data'], $leadId);
    json_response(['ok' => true, 'message' => "Thanks, we'll be in touch within 24 hours.", 'lead_id' => $leadId]);
} catch (Throwable $ex) {
    error_log('[submit-lead] DB error: ' . $ex->getMessage());
    json_response(['ok' => false, 'code' => 'server', 'message' => 'Something went wrong. Please try again.'], 500);
}
```

- [ ] **Step 3: Run tests**

```bash
vendor/bin/phpunit tests/unit/SubmitLeadTest.php
```

Expected: `OK (4 tests, ...)`.

- [ ] **Step 4: Commit**

```bash
git add src/handlers/submit_lead_logic.php src/handlers/submit-lead.php
git commit -m "feat: implement lead submission with CSRF, honeypot, validation, rate-limit, DB store, email"
```

---

### Task 36: Wire `/submit-lead` route

**Files:**
- Modify: `src/lib/router.php`

- [ ] **Step 1: Verify the route already exists**

`src/lib/router.php` already lists `'/submit-lead' => 'handlers/submit-lead'` from Task 15. Confirm by:

```bash
grep "submit-lead" src/lib/router.php
```

Expected output: `'/submit-lead'      => 'handlers/submit-lead',`

If missing for any reason, add it inside `routes_table()`.

- [ ] **Step 2: Manual end-to-end smoke**

Start XAMPP, point Apache `DocumentRoot` at `C:/xampp/htdocs/loan_consultant/public/`, restart Apache. Then:

```bash
curl -X POST http://localhost/submit-lead \
  -H 'Content-Type: application/json' \
  -d '{"name":"Test User","phone":"9876543210","loan_type":"personal","_csrf":"x"}'
```

Expected JSON response: `{"ok":false,"code":"csrf"}` (because we sent no session cookie — CSRF rejects). This proves the route is wired and the handler runs.

- [ ] **Step 3: No commit needed** (route was already in place from Task 15.)

---

## Phase H — Homepage

### Task 37: Homepage shell

**Files:**
- Create: `src/pages/home.php`

- [ ] **Step 1: Write `src/pages/home.php`** (minimal — full polish comes in Plan 2)

```php
<?php
$page_title = 'LoanSathi — Find the right loan for you, fast.';
$page_description = 'Compare personal, home, business, gold, and other loan offers from 20+ lenders. Free expert guidance, no fees from you. Get a callback in 24 hours.';
require __DIR__ . '/../partials/header.php';
?>

<!-- Hero (Layout D: split, photo right) -->
<section class="bg-navy text-white">
  <div class="container-page grid grid-cols-1 lg:grid-cols-2 min-h-[520px]">
    <div class="flex flex-col justify-center py-12 lg:py-16 pr-0 lg:pr-12">
      <p class="uppercase tracking-widest text-brand-amber text-xs font-bold mb-3">Your trusted loan companion</p>
      <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-[1.05]">
        Find the right loan, <span class="text-brand-amber">fast.</span>
      </h1>
      <p class="mt-5 text-slate-300 text-lg max-w-xl leading-relaxed">
        Personal, home, business, and more — we compare 20+ lenders and find the right fit. No fees from you.
      </p>
      <div class="mt-7 flex flex-wrap gap-3">
        <a href="#lead-form" class="btn-primary">Get Free Consultation</a>
        <a href="/emi-calculator" class="btn-secondary !text-white !border-white hover:!bg-white hover:!text-navy">Calculate EMI</a>
      </div>
      <div class="mt-6 text-sm text-slate-400 flex flex-wrap gap-x-5 gap-y-2">
        <span>★ 4.8 / 5</span>
        <span>•</span><span>2,000+ borrowers helped</span>
        <span>•</span><span>20+ lender partners</span>
      </div>
    </div>
    <div class="relative bg-gradient-to-br from-brand-blue to-navy-800 min-h-[260px] lg:min-h-[520px]">
      <!-- Replace with actual photo in Plan 2 -->
      <div class="absolute inset-0 flex items-center justify-center text-9xl opacity-70">🏠</div>
    </div>
  </div>
</section>

<!-- Loan tiles -->
<section class="container-page py-14">
  <h2 class="text-2xl sm:text-3xl text-center">What kind of loan do you need?</h2>
  <p class="text-center text-slate-500 mt-2 max-w-xl mx-auto">Pick a category to learn more, check eligibility, or get a callback.</p>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
    <?php
    $tiles = [
      ['personal-loan',           'Personal Loan',        '💼'],
      ['home-loan',               'Home Loan',            '🏠'],
      ['business-loan',           'Business Loan',        '📊'],
      ['gold-loan',               'Gold Loan',            '🪙'],
      ['loan-against-property',   'Loan Against Property','🏢'],
      ['education-loan',          'Education Loan',       '🎓'],
      ['vehicle-loan',            'Vehicle Loan',         '🚗'],
      ['emi-calculator',          'EMI Calculator',       '🧮'],
    ];
    foreach ($tiles as [$slug,$label,$emoji]): ?>
      <a href="/<?= e($slug) ?>" class="block rounded-2xl border border-slate-200 hover:border-navy hover:shadow-card transition p-5 bg-white">
        <div class="text-3xl"><?= $emoji ?></div>
        <div class="mt-3 font-bold text-navy"><?= e($label) ?></div>
        <div class="text-xs text-slate-500 mt-1">Learn more →</div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- How it works -->
<section class="bg-brand-surface py-14">
  <div class="container-page">
    <h2 class="text-2xl sm:text-3xl text-center">How it works</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
      <?php foreach ([
        ['1','Tell us what you need','Share your loan type, amount and a few quick details.'],
        ['2','We compare lenders','We screen 20+ banks and NBFCs for the best fit.'],
        ['3','Get the offer','A consultant calls you with options. You choose.'],
      ] as [$n,$t,$d]): ?>
        <div class="bg-white rounded-2xl p-6 shadow-card">
          <div class="w-10 h-10 rounded-full bg-navy text-white font-bold flex items-center justify-center"><?= $n ?></div>
          <h3 class="mt-4 text-lg"><?= e($t) ?></h3>
          <p class="text-slate-600 text-sm mt-2"><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Lead form -->
<section class="container-page py-14">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
    <div>
      <h2 class="text-2xl sm:text-3xl">Ready to start?</h2>
      <p class="text-slate-600 mt-3 max-w-md">Drop your details and a consultant will call you back within 24 hours.</p>
      <ul class="mt-5 space-y-2 text-sm text-slate-600">
        <li>✓ Free, no-obligation consultation</li>
        <li>✓ Compare offers from 20+ lenders</li>
        <li>✓ Faster approvals through pre-checked profiles</li>
      </ul>
    </div>
    <?php require __DIR__ . '/../partials/lead-form.php'; ?>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
```

- [ ] **Step 2: Commit**

```bash
git add src/pages/home.php
git commit -m "feat: add minimal homepage with hero, loan tiles, how-it-works, and lead form"
```

---

### Task 38: 404 page

**Files:**
- Create: `src/pages/404.php`

- [ ] **Step 1: Write `src/pages/404.php`**

```php
<?php
http_response_code(404);
$page_title = 'Page not found — LoanSathi';
$page_description = 'The page you were looking for does not exist. Browse our loan types or contact us for help.';
$page_robots = 'noindex,follow';
require __DIR__ . '/../partials/header.php';
?>

<section class="container-page py-20 text-center">
  <p class="text-brand-amber font-bold tracking-widest text-sm">404</p>
  <h1 class="mt-3 text-4xl sm:text-5xl">Page not found</h1>
  <p class="text-slate-600 mt-4 max-w-md mx-auto">
    The page you were looking for does not exist or has moved. Try one of these instead:
  </p>
  <div class="mt-8 flex flex-wrap gap-3 justify-center">
    <a class="btn-primary" href="/">Home</a>
    <a class="btn-secondary" href="/personal-loan">Personal Loan</a>
    <a class="btn-secondary" href="/emi-calculator">EMI Calculator</a>
    <a class="btn-secondary" href="/contact">Contact us</a>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
```

- [ ] **Step 2: Commit**

```bash
git add src/pages/404.php
git commit -m "feat: add branded 404 page with helpful links"
```

---

### Task 39: Thank-you page

**Files:**
- Create: `src/pages/thank-you.php`

- [ ] **Step 1: Write `src/pages/thank-you.php`**

```php
<?php
$page_title = 'Thanks — we\'ll be in touch | LoanSathi';
$page_description = 'Thanks for your enquiry. A LoanSathi consultant will call you within 24 hours.';
$page_robots = 'noindex,nofollow';
require __DIR__ . '/../partials/header.php';
?>

<section class="container-page py-20 text-center">
  <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 text-green-600 text-3xl">✓</div>
  <h1 class="mt-5 text-4xl sm:text-5xl">Thanks for reaching out!</h1>
  <p class="text-slate-600 mt-4 max-w-lg mx-auto">A LoanSathi consultant will call you within 24 hours. Need a faster reply? Message us on WhatsApp.</p>
  <div class="mt-8 flex flex-wrap gap-3 justify-center">
    <a class="btn-primary" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>" target="_blank" rel="noopener">Open WhatsApp</a>
    <a class="btn-secondary" href="/">Back to home</a>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
```

- [ ] **Step 2: Commit**

```bash
git add src/pages/thank-you.php
git commit -m "feat: add thank-you page (noindex) with WhatsApp deflection"
```

---

## Phase I — Verification & Wrap-up

### Task 40: Run all unit tests

- [ ] **Step 1: Run the full suite**

```bash
composer test
```

Expected: `OK (N tests, M assertions)` — all green. No failures.

- [ ] **Step 2: If anything fails:** investigate and fix before continuing.

- [ ] **Step 3: No commit needed if all green.**

---

### Task 41: Manual smoke checklist

- [ ] **Step 1: Start XAMPP** (Apache + MySQL). Point Apache `DocumentRoot` to `C:/xampp/htdocs/loan_consultant/public/`.

- [ ] **Step 2: Run Tailwind build**

```bash
npm run build
```

- [ ] **Step 3: Visit and verify**

Open each URL in a browser and confirm:

| URL | Expected |
|---|---|
| `http://localhost/` | Homepage renders. Hero shows "Find the right loan, fast." Loan tiles visible. Lead form is present. WhatsApp FAB bottom-right. Cookie banner bottom. Console: no errors. |
| `http://localhost/no-such-page` | Branded 404 page. HTTP 404 in network tab. |
| `http://localhost/submit-lead` (GET) | Returns `{"ok":false,"code":"method"}` with HTTP 405. |

- [ ] **Step 4: Submit a real lead from the form**

Fill the lead form on `/`. Submit. Expected: thank-you state inline. Then verify in MySQL:

```bash
php -r "require 'src/lib/db.php'; \$r=db()->query('SELECT id, name, phone, loan_type, source_form, created_at FROM leads ORDER BY id DESC LIMIT 5'); foreach (\$r as \$row) print_r(\$row);"
```

Expected: at least one row matching what you submitted.

- [ ] **Step 5: Verify mobile layout**

In browser devtools, switch to 360px width. Page should not horizontal-scroll. Nav collapses (the desktop nav is hidden on small — that's expected; mobile nav menu is in Plan 2).

- [ ] **Step 6: No commit needed.** Take a screenshot of homepage for the record.

---

### Task 42: Write smoke checklist file for future runs

**Files:**
- Create: `tests/smoke-checklist.md`

- [ ] **Step 1: Write `tests/smoke-checklist.md`**

```markdown
# Smoke Checklist — Plan 1 Foundation

Run after every deployment / major change.

## Build

- [ ] `composer install`
- [ ] `npm install && npm run build`
- [ ] `php bin/install.php` (idempotent)

## Pages

- [ ] `GET /` → 200, homepage renders, no console errors
- [ ] `GET /no-such-page` → 404, branded page
- [ ] `GET /thank-you` → 200, `<meta name="robots" content="noindex,nofollow">` present
- [ ] `GET /submit-lead` → 405

## Lead pipeline

- [ ] Submit a valid lead from the form → inline thank-you appears
- [ ] DB row inserted in `leads` table
- [ ] Email arrives at the configured lead inbox (if SMTP is configured)
- [ ] Submit lead with empty name → inline validation error visible
- [ ] Submit lead 6+ times from same IP within an hour → 429 response on the 6th

## Cross-cutting

- [ ] WhatsApp FAB visible on every page
- [ ] Cookie banner appears once; dismisses on "Got it"; stays dismissed after refresh
- [ ] Click-to-call number visible on mobile and desktop nav
- [ ] No PHP warnings in `storage/logs/`

## Tests

- [ ] `composer test` → all green
```

- [ ] **Step 2: Commit**

```bash
git add tests/smoke-checklist.md
git commit -m "docs: add Plan 1 smoke checklist"
```

---

### Task 43: Final push

- [ ] **Step 1: Verify clean working tree**

```bash
git status
```

Expected: `nothing to commit, working tree clean`.

- [ ] **Step 2: Push**

```bash
git push origin main
```

Expected: branch updated on GitHub.

- [ ] **Step 3: Tag the milestone (optional)**

```bash
git tag plan-1-foundation
git push origin plan-1-foundation
```

---

## Plan 1 — Done. What this gives you

A deployable LoanSathi PHP site with:

- Front-controller routing with pretty URLs
- DB schema (leads, admin_users, posts, rate_limit_log) created via `bin/install.php`
- Tested library: router, CSRF, validator (Indian phone), calculator (EMI), eligibility (7 loan types), rate-limiter, auth, mailer
- Reusable partials: header, footer, SEO meta, lead form (CSRF + honeypot + Alpine.js), WhatsApp FAB, cookie banner, breadcrumbs
- Working lead pipeline: form → validate → store → email (best-effort) → thank-you state
- Homepage with hero (Layout D), loan tiles, how-it-works, lead form
- Branded 404 + thank-you pages
- Security headers, secure session defaults, error logging
- Smoke checklist

**Not in this plan (covered later):**

- Plan 2: 7 loan landing pages, About/Contact/Legal, Application Guide
- Plan 3: EMI calculator UI, Eligibility Checker UI, Loan Comparison UI
- Plan 4: Admin (auth, dashboard, leads, posts CRUD), Blog public pages, JSON-LD enrichment, sitemap, SEO audit script
