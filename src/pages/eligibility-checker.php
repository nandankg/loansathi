<?php
$page_title = 'Loan Eligibility Checker — Estimate How Much You Can Borrow | LoanSathi';
$page_description = 'Free loan eligibility checker. Estimate how much you may qualify for based on income, existing EMIs, age, and credit score. Educational tool — no sign-up, no documents.';
$page_robots = 'index,follow';
$page_ad_safe = true; // Google Ads landing page — header CTA must not solicit a loan
require __DIR__ . '/../partials/header.php';
?>

<section class="bg-gradient-to-br from-surface-100 via-white to-surface-100 relative overflow-hidden">
  <div class="absolute -top-32 -right-20 w-[36rem] h-[36rem] rounded-full bg-glow-blue pointer-events-none"></div>
  <div class="container-page relative py-12 lg:py-16">
    <span class="eyebrow">Free tool · No sign-up</span>
    <h1 class="mt-4 font-display text-4xl sm:text-5xl font-extrabold text-ink max-w-3xl">
      Loan Eligibility Checker
    </h1>
    <p class="mt-4 text-lg text-ink-500 max-w-2xl leading-relaxed">
      Get a rough idea of how much you might qualify for, based on your income,
      existing EMIs, age, and credit score. No documents and no sign-up — this is
      an educational estimate, not an offer of credit.
    </p>
  </div>
</section>

<!-- ========== ELIGIBILITY TOOL ========== -->
<section class="py-12 lg:py-16 bg-white">
  <div class="container-page" id="eligibility-tool" x-data="eligibilityCheck()">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
      <div class="card lg:col-span-3">
        <div class="mb-7">
          <span class="eyebrow">Your details</span>
          <h2 class="mt-3 font-display text-2xl font-extrabold text-ink">Check how much you may qualify for</h2>
          <p class="mt-2 text-sm text-ink-500">Add your income, existing EMI, age, and credit range to estimate eligibility.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div class="sm:col-span-2">
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">I want a</label>
            <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2">
              <?php foreach (['personal','home','business','gold','lap','education','vehicle'] as $t): ?>
                <button type="button" data-elig-loan="<?= e($t) ?>" @click="loanType='<?= $t ?>'"
                        class="text-xs font-extrabold py-3 px-3 rounded-xl border-2 capitalize transition bg-white text-ink border-ink/10 hover:border-brand-500"
                        :class="loanType==='<?= $t ?>' ? '!bg-brand-500 !text-white !border-brand-500 shadow-card' : ''">
                  <?= $t === 'lap' ? 'LAP' : $t ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Monthly income</label>
            <div class="mt-2 relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-400 font-bold">₹</span>
              <input type="number" data-elig-field="income" x-model.number="income" class="input-field pl-8 nums font-semibold" min="0" value="60000">
            </div>
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Existing EMIs</label>
            <div class="mt-2 relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-400 font-bold">₹</span>
              <input type="number" data-elig-field="existingEmi" x-model.number="existingEmi" class="input-field pl-8 nums font-semibold" min="0" value="0">
            </div>
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Age</label>
            <input type="number" data-elig-field="age" x-model.number="age" class="input-field mt-2 nums font-semibold" min="18" max="80" value="30">
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Credit score</label>
            <select data-elig-field="score" x-model="score" class="input-field mt-2 font-semibold">
              <option value="excellent">750+ (Excellent)</option>
              <option value="good">700–749 (Good)</option>
              <option value="fair">650–699 (Fair)</option>
              <option value="below_650">Below 650</option>
            </select>
          </div>
        </div>
        <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:items-center">
          <button type="button" data-elig-calculate class="btn-success w-full sm:w-auto">
            Check Eligibility
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </button>
          <p class="text-xs text-ink-500">This is an estimate. Final eligibility depends on lender checks.</p>
        </div>
      </div>

      <div class="lg:col-span-2 bg-gradient-to-br from-brand-500 to-brand-700 text-white rounded-3xl p-7 sm:p-8 relative overflow-hidden">
        <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-accent-500/25 blur-2xl"></div>
        <div class="relative">
          <div class="text-[11px] uppercase tracking-[0.2em] text-white/70 font-extrabold">You may be eligible for up to</div>
          <div class="mt-3 font-mono text-5xl sm:text-6xl font-extrabold tracking-tight nums" data-elig-result="amount" x-text="result.eligible ? '₹' + formatNum(result.amount) : '—'">₹14.4 L</div>
          <p class="mt-3 text-sm text-white/80 leading-relaxed" data-elig-result="message" x-text="result.message">Based on your income and EMI capacity. Final offer depends on credit history.</p>
          <p class="mt-6 text-[11px] text-white/55 leading-relaxed">Indicative only. Final eligibility is determined by the lender based on documents and credit history.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== EXPLAINER ========== -->
<section class="py-12 lg:py-16 bg-surface-100">
  <div class="container-tight space-y-8 text-ink-700 leading-relaxed">
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">What affects loan eligibility?</h2>
      <p class="mt-3">
        Lenders look at your repayment capacity and risk before deciding how much
        to offer. The main factors are your <strong>income</strong>, your existing
        monthly obligations (<strong>FOIR / debt-to-income</strong>), your
        <strong>credit score</strong>, your <strong>age</strong> and remaining
        working years, and your employment or business stability. Secured loans
        (gold, property, vehicle) also depend on the value of the asset.
      </p>
    </div>
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">How to improve your eligibility</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li>Keep your credit score healthy — pay EMIs and card bills on time.</li>
        <li>Lower your existing EMIs or close small loans before applying.</li>
        <li>Add a co-applicant with income to boost the eligible amount.</li>
        <li>Choose a longer tenure (within reason) to fit a larger loan into your repayment capacity.</li>
        <li>Show stable, documented income — salary slips, ITRs, or bank statements.</li>
      </ul>
    </div>
    <div class="flex flex-wrap gap-3 pt-2">
      <a href="/emi-calculator" class="btn-secondary !text-sm">Calculate your EMI →</a>
      <a href="/loan-comparison" class="btn-secondary !text-sm">Compare loan types →</a>
      <a href="/application-guide" class="btn-secondary !text-sm">Read the application guide →</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/loan-disclosure.php'; ?>
<?php require __DIR__ . '/../partials/footer.php'; ?>
