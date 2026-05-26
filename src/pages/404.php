<?php
http_response_code(404);
$page_title = 'Page not found — LoanSathi';
$page_description = 'The page you were looking for does not exist. Browse our loan types or contact us for help.';
$page_robots = 'noindex,follow';
require __DIR__ . '/../partials/header.php';
?>

<section class="container-page py-20 lg:py-32 text-center">
  <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-accent-50 text-accent-500 mb-6">
    <svg viewBox="0 0 24 24" class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 9v4 M12 17h.01 M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
  </div>
  <p class="text-accent-500 font-extrabold tracking-[0.25em] text-sm uppercase">404</p>
  <h1 class="mt-3 font-display text-4xl sm:text-5xl font-extrabold">Page not found</h1>
  <p class="text-ink-500 mt-4 max-w-md mx-auto">
    The page you were looking for does not exist or has moved. Try one of these:
  </p>
  <div class="mt-8 flex flex-wrap gap-3 justify-center">
    <a class="btn-primary" href="/">Home</a>
    <a class="btn-secondary" href="/#tools">Tools</a>
    <a class="btn-secondary" href="/#lead-form">Contact</a>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
