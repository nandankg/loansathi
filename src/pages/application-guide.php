<?php
$page_title = 'Loan Application Guide — Documents, Steps & Tips | LoanSathi';
$page_description = 'A plain-English guide to applying for a loan in India: the documents you need, the step-by-step process, what lenders check, and tips to get approved faster.';
$page_robots = 'index,follow';
$page_ad_safe = true; // Google Ads landing page — header CTA must not solicit a loan
require __DIR__ . '/../partials/header.php';
?>

<section class="bg-gradient-to-br from-surface-100 via-white to-surface-100 relative overflow-hidden">
  <div class="absolute -top-32 -right-20 w-[36rem] h-[36rem] rounded-full bg-glow-blue pointer-events-none"></div>
  <div class="container-page relative py-12 lg:py-16">
    <span class="eyebrow">Guide · 5-min read</span>
    <h1 class="mt-4 font-display text-4xl sm:text-5xl font-extrabold text-ink max-w-3xl">
      Loan Application Guide
    </h1>
    <p class="mt-4 text-lg text-ink-500 max-w-2xl leading-relaxed">
      What to prepare, what to expect, and how to improve your odds — explained in
      plain English. This is educational information, not financial advice or an
      offer of credit.
    </p>
  </div>
</section>

<article class="py-12 lg:py-16 bg-white">
  <div class="container-tight space-y-10 text-ink-700 leading-relaxed">

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">The process, step by step</h2>
      <ol class="mt-4 space-y-4">
        <?php foreach ([
          ['Know your numbers', 'Use the EMI calculator and eligibility checker to understand what you can afford and roughly how much you may qualify for.'],
          ['Compare your options', 'Look at loan types, indicative rates, tenures, and fees. The lowest EMI is not always the cheapest loan once you add fees and total interest.'],
          ['Check your credit report', 'Get your free credit report (CIBIL/Experian/Equifax/CRIF). Fix errors and clear small dues before applying.'],
          ['Gather your documents', 'Keep the document set below ready as clear scans or photos to avoid back-and-forth.'],
          ['Apply with the right lender', 'Apply where your profile fits. Multiple hard enquiries in a short window can lower your score.'],
          ['Verification & sanction', 'The lender verifies your details, may do a field/credit check, then issues a sanction letter with the final rate, fees, and terms.'],
          ['Read, then sign & disburse', 'Read the sanction letter and Key Fact Statement carefully. Once you accept, funds are disbursed to your account.'],
        ] as $i => [$t,$d]): ?>
          <li class="flex gap-4">
            <span class="shrink-0 inline-flex items-center justify-center w-9 h-9 rounded-full bg-brand-50 text-brand-500 font-extrabold nums"><?= $i + 1 ?></span>
            <div>
              <div class="font-extrabold text-ink"><?= e($t) ?></div>
              <p class="mt-1 text-ink-500"><?= e($d) ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">Documents you'll typically need</h2>
      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <?php foreach ([
          ['Identity proof', 'PAN card (mandatory), plus Aadhaar, passport, voter ID, or driving licence.'],
          ['Address proof', 'Aadhaar, utility bill, rent agreement, or passport.'],
          ['Income proof (salaried)', 'Last 3 months’ salary slips and 6 months’ bank statements.'],
          ['Income proof (self-employed)', 'ITR for 2–3 years, business proof, and bank statements.'],
          ['Photographs', 'Recent passport-size photos.'],
          ['Asset documents (secured loans)', 'Property papers, gold valuation, or vehicle quotation, as applicable.'],
        ] as [$t,$d]): ?>
          <div class="card">
            <div class="font-extrabold text-ink"><?= e($t) ?></div>
            <p class="mt-1 text-sm text-ink-500"><?= e($d) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="mt-4 text-xs text-ink-400">Exact requirements vary by lender and loan type. LoanSathi does not collect these documents on this website.</p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">Tips to get approved faster</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li>Maintain a credit score of 750+ where possible.</li>
        <li>Keep your debt-to-income ratio low — clear small loans first.</li>
        <li>Provide complete, accurate, and consistent information.</li>
        <li>Avoid applying to many lenders at once.</li>
        <li>Add a co-applicant or collateral if your profile is borderline.</li>
      </ul>
    </section>

    <div class="flex flex-wrap gap-3 pt-2">
      <a href="/emi-calculator" class="btn-secondary !text-sm">Calculate your EMI →</a>
      <a href="/eligibility-checker" class="btn-secondary !text-sm">Check eligibility →</a>
      <a href="/loan-comparison" class="btn-secondary !text-sm">Compare loan types →</a>
    </div>
  </div>
</article>

<?php require __DIR__ . '/../partials/loan-disclosure.php'; ?>
<?php require __DIR__ . '/../partials/footer.php'; ?>
