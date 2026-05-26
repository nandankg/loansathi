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
