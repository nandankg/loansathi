<?php
$page_title = 'Contact LoanSathi';
$page_description = 'Get in touch with LoanSathi. Phone, email, WhatsApp, and our registered office address. We respond to enquiries within 24 hours.';
$page_robots = 'index,follow';
require __DIR__ . '/../partials/header.php';

$phone    = config('contact.phone');
$phone_ui = config('contact.phone_display');
$email    = config('contact.email');
$whatsapp = config('contact.whatsapp');
?>

<section class="bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500 text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-grid bg-[length:48px_48px] opacity-15 pointer-events-none"></div>
  <div class="container-page relative py-14 lg:py-20">
    <span class="chip-dark"><span class="w-1.5 h-1.5 rounded-full bg-success-400"></span> We're here to help</span>
    <h1 class="mt-5 font-display text-4xl sm:text-5xl font-extrabold">Contact us</h1>
    <p class="mt-4 text-white/80 max-w-2xl">Questions about comparing loans, our calculators, or your enquiry? Reach out — we usually respond within 24 hours.</p>
  </div>
</section>

<section class="py-14 lg:py-20 bg-white">
  <div class="container-page grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="card">
      <span class="icon-badge bg-success-50 text-success-500">
        <svg viewBox="0 0 24 24" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 5c0 9 7 16 16 16l2-4-4-2-2 2c-3-1-6-4-7-7l2-2-2-4-4-1Z"/></svg>
      </span>
      <h2 class="mt-5 font-display text-lg font-extrabold text-ink">Call us</h2>
      <a href="tel:<?= e($phone) ?>" class="mt-1 block text-brand-500 font-bold nums hover:text-brand-700"><?= e($phone_ui) ?></a>
      <p class="mt-2 text-sm text-ink-500">Mon–Sat, 10:00–19:00 IST</p>
    </div>

    <div class="card">
      <span class="icon-badge bg-brand-50 text-brand-500">
        <svg viewBox="0 0 24 24" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8l9 6 9-6 M3 8v10h18V8 M3 8l9-4 9 4"/></svg>
      </span>
      <h2 class="mt-5 font-display text-lg font-extrabold text-ink">Email us</h2>
      <a href="mailto:<?= e($email) ?>" class="mt-1 block text-brand-500 font-bold hover:text-brand-700"><?= e($email) ?></a>
      <p class="mt-2 text-sm text-ink-500">For support, privacy, and grievances.</p>
    </div>

    <div class="card">
      <span class="icon-badge bg-success-50 text-success-500">
        <svg viewBox="0 0 24 24" class="w-7 h-7" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5-1.3c1.5.8 3.2 1.3 5 1.3 5.5 0 10-4.5 10-10S17.5 2 12 2z"/></svg>
      </span>
      <h2 class="mt-5 font-display text-lg font-extrabold text-ink">WhatsApp</h2>
      <a href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener" class="mt-1 block text-brand-500 font-bold hover:text-brand-700">Message us</a>
      <p class="mt-2 text-sm text-ink-500">Fastest way to reach a consultant.</p>
    </div>
  </div>

  <div class="container-page mt-8">
    <div class="card bg-surface-100">
      <h2 class="font-display text-xl font-extrabold text-ink">Registered office</h2>
      <p class="mt-3 text-ink-700 leading-relaxed">
        <strong>FILL-IN: Registered Legal Entity Name</strong><br>
        FILL-IN: Building / Street<br>
        FILL-IN: City, State – PIN<br>
        India
      </p>
      <p class="mt-4 text-sm text-ink-500">
        Grievance Officer: <strong>FILL-IN: Name</strong> ·
        <a href="mailto:<?= e($email) ?>" class="text-brand-500 font-semibold"><?= e($email) ?></a>
      </p>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
