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
