<?php
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
  <meta name="theme-color" content="#0a2540">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset('css/site.css') ?>">
  <script defer src="https://unpkg.com/alpinejs@3.13.0/dist/cdn.min.js"></script>
  <?php require __DIR__ . '/seo-meta.php'; ?>
</head>
<body class="min-h-screen flex flex-col bg-white selection:bg-saffron/30 selection:text-navy">
<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:bg-navy focus:text-white focus:px-3 focus:py-2 focus:rounded-lg">Skip to content</a>

<header class="sticky top-0 z-40 bg-white/85 backdrop-blur border-b border-navy/5"
        x-data="{ mobileOpen: false }">
  <div class="container-page flex items-center justify-between h-16">
    <a href="/" class="flex items-center gap-2 group">
      <span class="relative inline-flex items-center justify-center w-9 h-9 rounded-xl bg-navy text-white">
        <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" aria-hidden="true">
          <path d="M4 19V8l8-5 8 5v11" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
          <path d="M9 19v-6h6v6" stroke="#ff8a3d" stroke-width="1.6" stroke-linejoin="round"/>
        </svg>
      </span>
      <span class="font-display text-[1.35rem] font-semibold tracking-tight text-navy">
        Loan<span class="text-saffron-600">Sathi</span>
      </span>
    </a>

    <nav class="hidden lg:flex items-center gap-1 text-sm">
      <a href="/#tools" class="btn-ghost">Tools</a>
      <a href="/#loans" class="btn-ghost">Loans</a>
      <a href="/#how-it-works" class="btn-ghost">How it works</a>
      <a href="/#faq" class="btn-ghost">FAQ</a>
      <a href="/about" class="btn-ghost">About</a>
    </nav>

    <div class="flex items-center gap-3">
      <a href="tel:<?= e($phone) ?>" class="hidden md:inline-flex items-center gap-1.5 text-sm font-semibold text-navy hover:text-saffron-600">
        <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 5c0 9 7 16 16 16l2-4-4-2-2 2c-3-1-6-4-7-7l2-2-2-4-4-1Z"/></svg>
        <?= e($phone_ui) ?>
      </a>
      <a href="#lead-form" class="btn-primary text-sm !px-4 !py-2.5">Apply Now
        <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 -mr-2 text-navy" aria-label="Toggle menu">
        <svg x-show="!mobileOpen" viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        <svg x-show="mobileOpen" viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><path d="M6 6l12 12M18 6L6 18"/></svg>
      </button>
    </div>
  </div>

  <div x-show="mobileOpen" x-cloak class="lg:hidden border-t border-navy/5 bg-white">
    <div class="container-page py-4 flex flex-col gap-1 text-sm">
      <a href="/#tools" class="py-2.5 font-semibold text-navy">Tools</a>
      <a href="/#loans" class="py-2.5 font-semibold text-navy">Loans</a>
      <a href="/#how-it-works" class="py-2.5 font-semibold text-navy">How it works</a>
      <a href="/#faq" class="py-2.5 font-semibold text-navy">FAQ</a>
      <a href="/about" class="py-2.5 font-semibold text-navy">About</a>
    </div>
  </div>
</header>
<main id="main" class="flex-1">
