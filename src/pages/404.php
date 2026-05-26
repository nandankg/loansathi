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
