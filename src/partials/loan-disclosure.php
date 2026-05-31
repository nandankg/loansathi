<?php
/**
 * Reusable loan cost-disclosure block.
 *
 * Matches the disclosure format Google's "Personal loans" advertising policy
 * requires on landing pages: minimum & maximum repayment period, the maximum
 * representative APR, and a representative example showing the total cost of
 * the loan including all applicable fees.
 *
 * Figures are illustrative for education only; LoanSathi does not lend and
 * does not set rates — see /disclaimer.
 */
?>
<section id="loan-disclosure" class="py-12 lg:py-16 bg-surface-100 border-t border-ink/5">
  <div class="container-page">
    <div class="max-w-3xl">
      <span class="eyebrow">Transparency disclosure</span>
      <h2 class="mt-3 font-display text-2xl sm:text-3xl font-extrabold text-ink">
        What loans actually cost
      </h2>
      <p class="mt-3 text-ink-500 leading-relaxed">
        LoanSathi is an independent loan-comparison and education service — we
        do not lend money and we do not decide your rate. The figures below are
        <strong class="text-ink">illustrative ranges</strong> across our
        partner lenders so you can understand the true cost of borrowing before
        you apply anywhere. Your actual rate, fees, and eligibility are set by
        the lender based on your profile.
      </p>
    </div>

    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="card">
        <div class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Repayment period</div>
        <div class="mt-2 font-display text-2xl font-extrabold text-ink nums">3 – 360 months</div>
        <p class="mt-1 text-xs text-ink-500">Min 3 months (short-term &amp; gold loans) to max 360 months (home loans).</p>
      </div>
      <div class="card">
        <div class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Representative APR</div>
        <div class="mt-2 font-display text-2xl font-extrabold text-ink nums">10.5% – 24% p.a.</div>
        <p class="mt-1 text-xs text-ink-500">APR includes interest plus typical fees. Lowest rates go to high-credit, secured borrowers.</p>
      </div>
      <div class="card">
        <div class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Typical fees</div>
        <div class="mt-2 font-display text-2xl font-extrabold text-ink nums">1% – 3% + GST</div>
        <p class="mt-1 text-xs text-ink-500">Processing fee. Some lenders add documentation, prepayment, or late-payment charges.</p>
      </div>
    </div>

    <div class="mt-6 card bg-white">
      <div class="text-[11px] uppercase tracking-wider font-extrabold text-brand-500">Representative example (illustrative)</div>
      <p class="mt-3 text-sm text-ink-700 leading-relaxed">
        If you borrow a <strong>personal loan of ₹1,00,000</strong> over a
        <strong>24-month</strong> term at a representative
        <strong>14% p.a. (reducing balance)</strong> interest rate, with a
        <strong>2% + 18% GST processing fee (₹2,360)</strong>, you would pay a
        monthly EMI of about <strong>₹4,802</strong>. Total interest over the
        term is about <strong>₹15,248</strong>, so the
        <strong>total amount repayable is about ₹1,17,608</strong>
        (principal ₹1,00,000 + interest ₹15,248 + fees ₹2,360), giving a
        <strong>representative APR of about 17.5%</strong>.
      </p>
      <p class="mt-3 text-xs text-ink-400 leading-relaxed">
        This example is for illustration only and is not an offer of credit.
        Actual interest rate, APR, fees, EMI, and eligibility vary by lender,
        loan type, amount, tenure, credit score, and income. Always read the
        lender's sanction letter and Key Fact Statement before signing.
        Terms &amp; conditions apply. See our
        <a href="/disclaimer" class="text-brand-500 font-semibold hover:text-brand-700">disclaimer</a>.
      </p>
    </div>
  </div>
</section>
