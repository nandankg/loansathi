<?php
$page_title = 'LoanSathi — Find the right loan for you, fast.';
$page_description = 'Compare personal, home, business, gold, and other loan offers from 20+ lenders. Free expert guidance, no fees from you. Get a callback in 24 hours.';
require __DIR__ . '/../partials/header.php';
?>

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
      <div class="absolute inset-0 flex items-center justify-center text-9xl opacity-70">🏠</div>
    </div>
  </div>
</section>

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
