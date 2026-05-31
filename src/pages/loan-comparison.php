<?php
$page_title = 'Loan Comparison — Compare Loan Types, Rates & Tenures | LoanSathi';
$page_description = 'Compare personal, home, business, gold, education, vehicle loans and LAP side by side: indicative rates, tenures, maximum amounts, and typical approval times.';
$page_robots = 'index,follow';
$page_ad_safe = true; // Google Ads landing page — header CTA must not solicit a loan
require __DIR__ . '/../partials/header.php';
?>

<section class="bg-gradient-to-br from-surface-100 via-white to-surface-100 relative overflow-hidden">
  <div class="absolute -top-32 -right-20 w-[36rem] h-[36rem] rounded-full bg-glow-blue pointer-events-none"></div>
  <div class="container-page relative py-12 lg:py-16">
    <span class="eyebrow">Free tool · No sign-up</span>
    <h1 class="mt-4 font-display text-4xl sm:text-5xl font-extrabold text-ink max-w-3xl">
      Loan Comparison
    </h1>
    <p class="mt-4 text-lg text-ink-500 max-w-2xl leading-relaxed">
      A side-by-side look at common loan types in India — indicative starting
      rates, typical tenures, maximum amounts, and how long approval usually
      takes. Use it to understand your options before you apply anywhere.
    </p>
  </div>
</section>

<section class="py-12 lg:py-16 bg-white">
  <div class="container-page">
    <div class="card overflow-hidden p-0">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-surface-100 text-ink-500 uppercase text-[11px] tracking-wider">
            <tr>
              <th class="text-left px-6 py-4 font-extrabold">Loan type</th>
              <th class="text-left px-6 py-4 font-extrabold">Rate from</th>
              <th class="text-left px-6 py-4 font-extrabold">Tenure</th>
              <th class="text-left px-6 py-4 font-extrabold">Max amount</th>
              <th class="text-left px-6 py-4 font-extrabold">Approval</th>
              <th class="px-6 py-4"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-ink/5">
            <?php
            $rows = [
              ['personal','Personal Loan','10.5%','12–60 mo','₹40 L','2–5 days','brand',  'M9 7h6l2 13H7L9 7z M10 7V4h4v3'],
              ['home','Home Loan','8.5%','60–360 mo','₹5 Cr+','7–14 days','accent', 'M3 12l9-9 9 9 M5 10v10h14V10'],
              ['business','Business Loan','12%','12–60 mo','₹50 L','5–10 days','success', 'M4 20V8 M10 20V4 M16 20v-8 M22 20H2'],
              ['gold','Gold Loan','9.0%','3–24 mo','75% LTV','Same day','accent', 'M12 2l2.5 5 5.5.8-4 3.9.9 5.4L12 14.8 7.1 17l.9-5.4-4-3.9 5.5-.8z'],
              ['lap','Loan Against Property','9.5%','60–180 mo','₹3 Cr','10–20 days','brand', 'M3 20h18 M5 20V8l7-4 7 4v12 M10 20v-6h4v6'],
              ['education','Education Loan','10.0%','60–180 mo','₹50 L','7–21 days','success', 'M3 8l9-4 9 4-9 4-9-4z M5 10v5l7 3 7-3v-5'],
              ['vehicle','Vehicle Loan','9.5%','12–84 mo','85% on-road','2–5 days','accent', 'M3 13l2-7h14l2 7v5H3z M7 18a2 2 0 100-4 2 2 0 000 4z M17 18a2 2 0 100-4 2 2 0 000 4z'],
            ];
            foreach ($rows as [$slug,$label,$rate,$tenure,$max,$approval,$color,$path]):
              $bg = $color === 'success' ? 'bg-success-50 text-success-500' : ($color === 'accent' ? 'bg-accent-50 text-accent-500' : 'bg-brand-50 text-brand-500');
            ?>
              <tr class="hover:bg-surface-100 transition">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl <?= $bg ?>">
                      <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="<?= $path ?>"/></svg>
                    </span>
                    <span class="font-extrabold text-ink"><?= e($label) ?></span>
                  </div>
                </td>
                <td class="px-6 py-4 font-mono nums font-extrabold text-accent-500"><?= e($rate) ?></td>
                <td class="px-6 py-4 text-ink-500 nums"><?= e($tenure) ?></td>
                <td class="px-6 py-4 text-ink-500 nums"><?= e($max) ?></td>
                <td class="px-6 py-4 text-ink-500"><?= e($approval) ?></td>
                <td class="px-6 py-4 text-right">
                  <a href="/emi-calculator" class="text-brand-500 font-extrabold text-sm hover:text-brand-700 whitespace-nowrap">
                    Calculate EMI →
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <p class="mt-4 text-xs text-ink-500 leading-relaxed max-w-3xl">
      Rates shown are indicative starting rates for well-qualified borrowers.
      Your offer depends on credit score, income, employer category, and other
      factors. LoanSathi does not lend — we provide comparison and education.
    </p>
  </div>
</section>

<!-- ========== HOW TO CHOOSE ========== -->
<section class="py-12 lg:py-16 bg-surface-100">
  <div class="container-tight space-y-8 text-ink-700 leading-relaxed">
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">Secured vs. unsecured loans</h2>
      <p class="mt-3">
        <strong>Secured loans</strong> (home, gold, vehicle, loan against
        property) are backed by an asset, so they usually carry
        <strong>lower interest rates</strong> and higher amounts — but the lender
        can claim the asset if you default. <strong>Unsecured loans</strong>
        (personal, many business loans) need no collateral and disburse faster,
        but rates are higher and limits are tied to your income and credit score.
      </p>
    </div>
    <div>
      <h2 class="font-display text-2xl font-extrabold text-ink">How to choose the right loan</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li><strong>Match the loan to the purpose</strong> — a home loan for property, gold loan for short-term cash, education loan for studies.</li>
        <li><strong>Compare the APR, not just the headline rate</strong> — fees and charges change the true cost.</li>
        <li><strong>Check the total interest over the tenure</strong>, not only the monthly EMI.</li>
        <li><strong>Read prepayment and foreclosure terms</strong> before signing.</li>
        <li><strong>Borrow only what you can comfortably repay.</strong></li>
      </ul>
    </div>
    <div class="flex flex-wrap gap-3 pt-2">
      <a href="/emi-calculator" class="btn-secondary !text-sm">Calculate your EMI →</a>
      <a href="/eligibility-checker" class="btn-secondary !text-sm">Check eligibility →</a>
      <a href="/application-guide" class="btn-secondary !text-sm">Read the application guide →</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/loan-disclosure.php'; ?>
<?php require __DIR__ . '/../partials/footer.php'; ?>
