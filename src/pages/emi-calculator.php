<?php
$page_title = 'EMI Calculator — Estimate Your Monthly Loan Payment | LoanSathi';
$page_description = 'Free EMI calculator. Estimate the monthly instalment, total interest, and total cost for any loan amount, interest rate, and tenure. Educational tool — no sign-up.';
$page_robots = 'index,follow';
$page_ad_safe = true; // Google Ads landing page — header CTA must not solicit a loan
require __DIR__ . '/../partials/header.php';
?>

<section class="bg-gradient-to-br from-surface-100 via-white to-surface-100 relative overflow-hidden">
  <div class="absolute -top-32 -right-20 w-[36rem] h-[36rem] rounded-full bg-glow-blue pointer-events-none"></div>
  <div class="container-page relative py-12 lg:py-16">
    <span class="eyebrow">Free tool · No sign-up</span>
    <h1 class="mt-4 font-display text-4xl sm:text-5xl font-extrabold text-ink max-w-3xl">
      EMI Calculator
    </h1>
    <p class="mt-4 text-lg text-ink-500 max-w-2xl leading-relaxed">
      See what a loan would cost you every month before you borrow. Enter an
      amount, interest rate, and tenure to estimate your EMI, total interest, and
      total repayment. This is an educational estimate — your actual figures are
      set by the lender.
    </p>
  </div>
</section>

<!-- ========== EMI CALCULATOR TOOL ========== -->
<section class="py-12 lg:py-16 bg-white">
  <div class="container-page" id="emi-tool" x-data="emiCalc()">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
      <div class="card lg:col-span-3">
        <div class="mb-7">
          <span class="eyebrow">Inputs</span>
          <h2 class="mt-3 font-display text-2xl font-extrabold text-ink">Plan your monthly payment</h2>
          <p class="mt-2 text-sm text-ink-500">Enter amount, rate, and tenure, then calculate your EMI instantly.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Loan type</label>
            <select data-emi-field="loanType" x-model="loanType" @change="syncDefaults" class="input-field mt-2 font-semibold">
              <option value="personal">Personal Loan</option>
              <option value="home">Home Loan</option>
              <option value="business">Business Loan</option>
              <option value="gold">Gold Loan</option>
              <option value="lap">Loan Against Property</option>
              <option value="education">Education Loan</option>
              <option value="vehicle">Vehicle Loan</option>
            </select>
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Loan amount</label>
            <div class="mt-2 relative">
              <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-400 font-bold">₹</span>
              <input type="number" data-emi-field="amount" x-model.number="amount" class="input-field pl-8 nums font-semibold" min="50000" max="50000000" step="10000" value="500000">
            </div>
            <input type="range" data-emi-field="amount" min="50000" max="20000000" step="50000" x-model.number="amount" class="range-brand w-full mt-3" value="500000">
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Interest rate</label>
            <div class="mt-2 relative">
              <input type="number" data-emi-field="rate" step="0.1" x-model.number="rate" class="input-field pr-10 nums font-semibold" value="10.5">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-ink-400 font-bold">%</span>
            </div>
            <input type="range" data-emi-field="rate" min="5" max="24" step="0.1" x-model.number="rate" class="range-brand w-full mt-3" value="10.5">
          </div>
          <div>
            <label class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Tenure (months)</label>
            <input type="number" data-emi-field="tenure" x-model.number="tenure" class="input-field mt-2 nums font-semibold" min="3" max="360" value="36">
            <input type="range" data-emi-field="tenure" min="3" max="360" step="3" x-model.number="tenure" class="range-brand w-full mt-3" value="36">
          </div>
        </div>
        <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:items-center">
          <button type="button" data-emi-calculate class="btn-primary w-full sm:w-auto">
            Calculate EMI
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
          </button>
          <p class="text-xs text-ink-500">Change any value and press Calculate to refresh the result.</p>
        </div>
      </div>

      <div class="lg:col-span-2 bg-gradient-to-br from-brand-500 to-brand-700 text-white rounded-3xl p-7 sm:p-8 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-accent-500/30 blur-2xl"></div>
        <div class="relative">
          <div class="text-[11px] uppercase tracking-[0.2em] text-white/70 font-extrabold">Your monthly EMI</div>
          <div class="mt-3 font-mono text-5xl sm:text-6xl font-extrabold tracking-tight nums" data-emi-result="emi" x-text="'₹' + formatNum(emi)">₹15,934</div>
          <div class="mt-1 text-sm text-white/60">on a ₹<span class="nums" data-emi-result="amount" x-text="formatNum(amount)">5,00,000</span> loan</div>

          <div class="mt-7 grid grid-cols-2 gap-3 text-sm">
            <div class="rounded-2xl bg-white/10 p-4 border border-white/15 backdrop-blur">
              <div class="text-white/70 text-[10px] uppercase tracking-wider font-extrabold">Total interest</div>
              <div class="font-mono text-xl mt-1 nums font-extrabold" data-emi-result="totalInterest" x-text="'₹' + formatNum(totalInterest)">₹73,624</div>
            </div>
            <div class="rounded-2xl bg-white/10 p-4 border border-white/15 backdrop-blur">
              <div class="text-white/70 text-[10px] uppercase tracking-wider font-extrabold">Total payment</div>
              <div class="font-mono text-xl mt-1 nums font-extrabold" data-emi-result="totalPayment" x-text="'₹' + formatNum(totalPayment)">₹5,73,624</div>
            </div>
          </div>

          <div class="mt-7 flex items-center gap-5">
            <div class="relative w-20 h-20">
              <svg viewBox="0 0 36 36" class="w-20 h-20 -rotate-90">
                <circle cx="18" cy="18" r="14.4" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="3.5"></circle>
                <circle data-emi-circle cx="18" cy="18" r="14.4" fill="none" stroke="#ff6b35" stroke-width="3.5"
                        stroke-dasharray="100" :stroke-dashoffset="100 - principalPct" pathLength="100"
                        stroke-linecap="round" style="transition: stroke-dashoffset 400ms ease"></circle>
              </svg>
              <div class="absolute inset-0 flex items-center justify-center text-xs font-extrabold nums" data-emi-result="principalPct" x-text="principalPct.toFixed(0) + '%'">87%</div>
            </div>
            <div class="text-xs leading-relaxed text-white/85 font-semibold">
              <div><span class="inline-block w-2 h-2 rounded-full bg-accent-500 mr-1.5"></span>Principal</div>
              <div class="mt-1"><span class="inline-block w-2 h-2 rounded-full bg-white/30 mr-1.5"></span>Interest</div>
            </div>
          </div>
          <p class="mt-6 text-[11px] text-white/55 leading-relaxed">Indicative estimate only. Actual EMI depends on the lender's rate, fees, and terms.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== EXPLAINER ========== -->
<section class="py-12 lg:py-16 bg-surface-100">
  <div class="container-tight space-y-8 text-ink-700 leading-relaxed">
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">What is an EMI?</h2>
      <p class="mt-3">
        EMI stands for <strong>Equated Monthly Instalment</strong> — the fixed
        amount you repay to a lender each month until the loan is cleared. Each
        EMI has two parts: <strong>principal</strong> (the borrowed amount) and
        <strong>interest</strong> (the lender's charge). In the early months, more
        of your EMI goes towards interest; later, more goes towards principal.
      </p>
    </div>
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">How EMI is calculated</h2>
      <p class="mt-3">
        Most loans in India use the <strong>reducing-balance</strong> method. The
        EMI is derived from three inputs: the loan amount (P), the monthly
        interest rate (R), and the number of months (N). A longer tenure lowers
        your monthly EMI but increases the total interest you pay over the life of
        the loan — so the cheapest monthly payment is rarely the cheapest loan.
      </p>
    </div>
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">Tips to lower your EMI</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li>Improve your credit score to qualify for a lower interest rate.</li>
        <li>Make a larger down payment to reduce the principal.</li>
        <li>Compare offers from multiple lenders before committing.</li>
        <li>Consider prepayment to cut total interest (check prepayment charges first).</li>
      </ul>
    </div>
    <div class="flex flex-wrap gap-3 pt-2">
      <a href="/eligibility-checker" class="btn-secondary !text-sm">Check eligibility →</a>
      <a href="/loan-comparison" class="btn-secondary !text-sm">Compare loan types →</a>
      <a href="/application-guide" class="btn-secondary !text-sm">Read the application guide →</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/loan-disclosure.php'; ?>
<?php require __DIR__ . '/../partials/footer.php'; ?>
