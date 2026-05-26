<?php
$slug = $GLOBALS['route_params']['slug'] ?? '';
$titles = [
  'personal-loan' => ['Personal Loan', 'personal'],
  'home-loan' => ['Home Loan', 'home'],
  'business-loan' => ['Business Loan', 'business'],
  'gold-loan' => ['Gold Loan', 'gold'],
  'loan-against-property' => ['Loan Against Property', 'lap'],
  'education-loan' => ['Education Loan', 'education'],
  'vehicle-loan' => ['Vehicle Loan', 'vehicle'],
  'emi-calculator' => ['EMI Calculator', null],
  'eligibility-checker' => ['Eligibility Checker', null],
  'loan-comparison' => ['Loan Comparison', null],
  'application-guide' => ['Application Guide', null],
  'about' => ['About LoanSathi', null],
  'contact' => ['Contact Us', null],
  'blog' => ['Blog', null],
  'privacy-policy' => ['Privacy Policy', null],
  'terms-of-service' => ['Terms of Service', null],
  'disclaimer' => ['Disclaimer', null],
];

$reqPath = ltrim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '', '/');
[$label, $loanType] = $titles[$reqPath] ?? [ucwords(str_replace('-', ' ', $reqPath)), null];

$isToolPage   = in_array($reqPath, ['emi-calculator','eligibility-checker','loan-comparison'], true);
$anchor       = $isToolPage ? '#tools' : '#lead-form';

$page_title = $label . ' — LoanSathi';
$page_description = 'A dedicated ' . $label . ' page is coming soon. In the meantime, use our homepage tools or request a callback in 24 hours.';
$page_robots = 'noindex,follow';
require __DIR__ . '/../partials/header.php';
?>

<section class="bg-navy text-white relative overflow-hidden grain">
  <div class="absolute -top-32 -right-32 w-[36rem] h-[36rem] rounded-full bg-radial-amber opacity-90 pointer-events-none"></div>
  <div class="container-page relative py-20 lg:py-28">
    <div class="max-w-2xl">
      <span class="chip-dark">Section under construction</span>
      <h1 class="mt-6 font-display text-5xl sm:text-6xl lg:text-7xl leading-[1] font-semibold">
        <?= e($label) ?> <span class="italic font-light text-cream">page</span> is on its way.
      </h1>
      <p class="mt-7 text-lg text-cream/80 leading-relaxed max-w-xl">
        <?php if ($isToolPage): ?>
          The standalone <?= e($label) ?> page is being built. In the meantime, the full interactive tool is already live on our homepage.
        <?php elseif ($loanType !== null): ?>
          We're writing the full <?= e($label) ?> guide. Until then, you can run the numbers on our calculators and request a callback — a consultant will walk you through everything.
        <?php else: ?>
          We're putting the finishing touches on this page. In the meantime, the homepage has everything you need to get started.
        <?php endif; ?>
      </p>
      <div class="mt-9 flex flex-wrap gap-3">
        <a href="/<?= e($anchor) ?>" class="btn-primary">
          <?php if ($isToolPage): ?>Go to the tool<?php elseif ($loanType !== null): ?>Try the calculator<?php else: ?>Back to home<?php endif; ?>
          <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
        <?php if ($loanType !== null): ?>
          <a href="/#lead-form" onclick="window.__leadPrefill='<?= e($loanType) ?>'" class="btn-secondary !bg-white/5 !border-white/20 !text-white hover:!bg-white hover:!text-navy">
            Get a <?= e($label) ?> callback
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="py-16 bg-cream-50">
  <div class="container-page">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <a href="/#tools" class="card group hover:-translate-y-1 transition">
        <div class="text-saffron-600">
          <svg viewBox="0 0 24 24" class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 7h16M4 12h16M4 17h10"/></svg>
        </div>
        <h3 class="mt-4 font-display text-xl">Run the numbers</h3>
        <p class="mt-2 text-sm text-navy/65">EMI, eligibility, rate comparison — all interactive, no sign-up.</p>
      </a>
      <a href="/#loans" class="card group hover:-translate-y-1 transition">
        <div class="text-saffron-600">
          <svg viewBox="0 0 24 24" class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 6h18v12H3z M3 10h18 M8 14h8"/></svg>
        </div>
        <h3 class="mt-4 font-display text-xl">Browse loan types</h3>
        <p class="mt-2 text-sm text-navy/65">Indicative rates, max amounts, and typical approval times for every category.</p>
      </a>
      <a href="/#lead-form" class="card group hover:-translate-y-1 transition">
        <div class="text-saffron-600">
          <svg viewBox="0 0 24 24" class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 11c0 4-4 8-9 8a9 9 0 01-3-.5L4 20l1.5-5A8 8 0 013 11c0-4 4-8 9-8s9 4 9 8z"/></svg>
        </div>
        <h3 class="mt-4 font-display text-xl">Talk to a consultant</h3>
        <p class="mt-2 text-sm text-navy/65">Free, no-obligation callback within 24 hours. We do the running around.</p>
      </a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
