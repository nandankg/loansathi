<?php
$page_title = 'Disclaimer — LoanSathi';
$page_description = 'Important disclaimer: LoanSathi is an independent loan-comparison and education service. We are not a lender and not an RBI-registered entity. Rates are indicative.';
$page_robots = 'index,follow';
require __DIR__ . '/../partials/header.php';

$updated = 'May 31, 2026';
?>

<section class="bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500 text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-grid bg-[length:48px_48px] opacity-15 pointer-events-none"></div>
  <div class="container-page relative py-14 lg:py-20">
    <span class="chip-dark"><span class="w-1.5 h-1.5 rounded-full bg-success-400"></span> Legal</span>
    <h1 class="mt-5 font-display text-4xl sm:text-5xl font-extrabold">Disclaimer</h1>
    <p class="mt-4 text-white/80 max-w-2xl">Last updated: <?= e($updated) ?></p>
  </div>
</section>

<article class="py-14 lg:py-20 bg-white">
  <div class="container-tight space-y-8 text-ink-700 leading-relaxed">

    <div class="card bg-accent-50 border-l-4 border-accent-500">
      <p class="text-ink font-semibold">
        LoanSathi is an independent loan-comparison and financial-education
        platform. <strong>We are not a lender, not a bank, and not an
        RBI-registered NBFC.</strong> We do not disburse loans or make credit
        decisions. We help you compare options and, only if you ask, introduce
        you to third-party partner lenders.
      </p>
    </div>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">Information is educational only</h2>
      <p class="mt-3">
        All content on this website — including interest rates, APRs, EMIs,
        eligibility estimates, fees, maximum amounts, and approval timelines — is
        <strong>indicative and provided for general educational purposes only</strong>.
        It does not constitute financial, legal, or tax advice, and it is not an
        offer or guarantee of credit.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">Your actual terms come from the lender</h2>
      <p class="mt-3">
        Real interest rate, APR, processing and other fees, loan amount, tenure,
        and eligibility are determined <strong>solely by the lender</strong>
        based on your credit profile, income, documents, and their internal
        policies. Figures may differ significantly from any estimate shown here
        and can change without notice. Always read the lender's sanction letter
        and Key Fact Statement before signing.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">Borrow responsibly</h2>
      <p class="mt-3">
        Loans are a financial commitment. Borrow only what you need and can
        comfortably repay. Missing payments can hurt your credit score and lead
        to penalties. If unsure, consult a qualified financial advisor.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">No liability</h2>
      <p class="mt-3">
        LoanSathi accepts no liability for decisions made, or loans taken, based
        on information on this site, nor for the products or conduct of any
        third-party lender. Trademarks and lender names shown are the property of
        their respective owners and are used only for identification of comparison
        options; their mention does not imply endorsement or partnership unless
        explicitly stated.
      </p>
    </section>

    <div class="pt-6 border-t border-ink/10 text-sm text-ink-500">
      See also our <a href="/privacy-policy" class="text-brand-500 font-semibold">Privacy Policy</a>
      and <a href="/terms-of-service" class="text-brand-500 font-semibold">Terms of Service</a>.
    </div>
  </div>
</article>

<?php require __DIR__ . '/../partials/footer.php'; ?>
