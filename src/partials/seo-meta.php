<?php
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
