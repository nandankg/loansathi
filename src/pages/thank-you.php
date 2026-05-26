<?php
$page_title = 'Thanks — we\'ll be in touch | LoanSathi';
$page_description = 'Thanks for your enquiry. A LoanSathi consultant will call you within 24 hours.';
$page_robots = 'noindex,nofollow';
require __DIR__ . '/../partials/header.php';
?>

<section class="container-page py-20 lg:py-32 text-center">
  <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-success-50 text-success-500 mb-6">
    <svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg>
  </div>
  <h1 class="mt-3 font-display text-4xl sm:text-5xl font-extrabold">Thanks for reaching out!</h1>
  <p class="text-ink-500 mt-4 max-w-lg mx-auto text-lg">A LoanSathi consultant will call you within 24 hours. Need a faster reply? Message us on WhatsApp.</p>
  <div class="mt-8 flex flex-wrap gap-3 justify-center">
    <a class="btn-success" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>" target="_blank" rel="noopener">
      <svg viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5-1.3c1.5.8 3.2 1.3 5 1.3 5.5 0 10-4.5 10-10S17.5 2 12 2z"/></svg>
      Open WhatsApp
    </a>
    <a class="btn-secondary" href="/">Back to home</a>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
