<?php
$page_title = 'LoanSathi — Compare loans, calculate EMI, get matched in 24 hours';
$page_description = 'India\'s smart loan companion. Compare personal, home, business, gold and other loans from 20+ lenders. Instant EMI calculator and eligibility checker. Free expert guidance, no fees from you.';
require __DIR__ . '/../partials/header.php';
?>

<!-- ========================= HERO ========================= -->
<section class="relative overflow-hidden bg-navy text-white grain">
  <!-- decorative bg -->
  <div class="absolute inset-0 bg-grid bg-[length:32px_32px] opacity-[0.18] pointer-events-none"></div>
  <div class="absolute -top-32 -right-32 w-[42rem] h-[42rem] rounded-full bg-radial-amber opacity-90 pointer-events-none"></div>
  <div class="absolute -bottom-20 -left-20 w-[26rem] h-[26rem] rounded-full bg-radial-amber opacity-60 pointer-events-none"></div>

  <div class="container-page relative pt-14 pb-20 lg:pt-20 lg:pb-28">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
      <!-- LEFT: editorial copy -->
      <div class="lg:col-span-7 animate-fade-up">
        <div class="flex items-center gap-2">
          <span class="chip-dark"><span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse-soft"></span> 2,000+ loans facilitated</span>
          <span class="chip-dark hidden sm:inline-flex">★ 4.8 / 5 from borrowers</span>
        </div>
        <h1 class="mt-6 font-display font-semibold text-[2.6rem] sm:text-6xl lg:text-[5.2rem] leading-[0.98] tracking-tight">
          The right loan,<br>
          <span class="italic font-light text-cream">found for you</span><br>
          <span class="text-saffron">in 24 hours.</span>
        </h1>
        <p class="mt-7 max-w-xl text-lg text-cream/80 leading-relaxed">
          Tell us once. We compare offers from <strong class="text-white">20+ banks &amp; NBFCs</strong>, pre-check your eligibility, and route the best three to your phone — no spam, no fees.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="#tools" class="btn-primary text-base">
            Try our calculators
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 5v14M5 12h14"/></svg>
          </a>
          <a href="#lead-form" class="btn-secondary !bg-white/5 !border-white/20 !text-white hover:!bg-white hover:!text-navy">
            Get a callback
          </a>
        </div>
        <div class="mt-10 grid grid-cols-3 gap-6 max-w-xl">
          <div>
            <div class="font-display text-3xl text-saffron nums">8.5%</div>
            <div class="text-xs uppercase tracking-wider text-cream/60 mt-1">Home loan from</div>
          </div>
          <div>
            <div class="font-display text-3xl text-saffron nums">₹50L</div>
            <div class="text-xs uppercase tracking-wider text-cream/60 mt-1">Max disbursed</div>
          </div>
          <div>
            <div class="font-display text-3xl text-saffron nums">20+</div>
            <div class="text-xs uppercase tracking-wider text-cream/60 mt-1">Lender partners</div>
          </div>
        </div>
      </div>

      <!-- RIGHT: live EMI mini-preview card -->
      <div class="lg:col-span-5 animate-fade-up" style="animation-delay:120ms"
           x-data="emiHero()">
        <div class="relative">
          <div class="absolute -inset-4 bg-saffron/15 rounded-[2rem] blur-2xl"></div>
          <div class="relative bg-white text-navy rounded-[1.8rem] shadow-deep p-7 border border-white/30">
            <div class="flex items-center justify-between">
              <span class="eyebrow !text-saffron-600">Live preview</span>
              <span class="text-[10px] uppercase tracking-widest font-bold text-navy/40">EMI ₹</span>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
              <span class="font-mono text-5xl sm:text-6xl font-bold tracking-tight nums" x-text="formatINR(emi)"></span>
              <span class="text-sm text-navy/50">/ month</span>
            </div>
            <p class="text-xs text-navy/50 mt-1">at <span x-text="rate"></span>% for <span x-text="tenure"></span> months on <span x-text="formatINR(amount, true)"></span></p>

            <div class="mt-6 space-y-5">
              <label class="block">
                <div class="flex justify-between text-xs font-semibold text-navy/70 mb-1.5">
                  <span>Loan amount</span><span class="nums">₹<span x-text="formatNum(amount)"></span></span>
                </div>
                <input type="range" min="100000" max="10000000" step="50000" x-model.number="amount" class="range-saffron w-full">
              </label>
              <label class="block">
                <div class="flex justify-between text-xs font-semibold text-navy/70 mb-1.5">
                  <span>Interest rate</span><span class="nums" x-text="rate + '% p.a.'"></span>
                </div>
                <input type="range" min="6" max="22" step="0.1" x-model.number="rate" class="range-saffron w-full">
              </label>
              <label class="block">
                <div class="flex justify-between text-xs font-semibold text-navy/70 mb-1.5">
                  <span>Tenure</span><span class="nums" x-text="tenure + ' months'"></span>
                </div>
                <input type="range" min="6" max="360" step="6" x-model.number="tenure" class="range-saffron w-full">
              </label>
            </div>
            <a href="#tools" class="mt-6 inline-flex items-center gap-1.5 text-sm font-bold text-saffron-600 hover:text-saffron-700">
              See full breakdown
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================= TRUST STRIP ========================= -->
<section class="border-y border-navy/5 bg-cream-50 py-6 overflow-hidden">
  <div class="container-page flex items-center gap-6 flex-wrap">
    <div class="text-xs uppercase tracking-[0.18em] text-navy/50 font-semibold whitespace-nowrap">Lender partners</div>
    <div class="flex-1 flex flex-wrap items-center gap-x-10 gap-y-3 text-navy/55 text-base font-semibold">
      <span class="opacity-80">HDFC Bank</span>
      <span class="opacity-80">ICICI</span>
      <span class="opacity-80">Axis Bank</span>
      <span class="opacity-80">Bajaj Finserv</span>
      <span class="opacity-80">Tata Capital</span>
      <span class="opacity-80">SBI</span>
      <span class="opacity-80">Kotak</span>
      <span class="opacity-80">+ 13 more</span>
    </div>
  </div>
</section>

<!-- ========================= TOOLS HUB ========================= -->
<section id="tools" class="py-20 lg:py-28 bg-cream-50 relative overflow-hidden"
         x-data="{ tab: 'emi' }">
  <div class="absolute top-0 right-0 w-80 h-80 -mr-32 -mt-32 rounded-full bg-saffron/10 blur-3xl"></div>

  <div class="container-page relative">
    <div class="max-w-2xl">
      <span class="eyebrow">Tools — try before you talk</span>
      <h2 class="h-section mt-3">Math first. <span class="italic font-light text-navy/60">Forms later.</span></h2>
      <p class="mt-4 text-navy/65 text-lg max-w-xl">No sign-up. No phone-number gate. Run the numbers right here, then ask for a callback only when it makes sense.</p>
    </div>

    <!-- Tab nav -->
    <div class="mt-10 inline-flex p-1.5 rounded-full bg-white border border-navy/5 shadow-card">
      <button @click="tab='emi'" :class="tab==='emi' ? 'tool-tab active' : 'tool-tab'">
        EMI Calculator
      </button>
      <button @click="tab='eligibility'" :class="tab==='eligibility' ? 'tool-tab active' : 'tool-tab'">
        Eligibility
      </button>
      <button @click="tab='compare'" :class="tab==='compare' ? 'tool-tab active' : 'tool-tab'">
        Compare rates
      </button>
    </div>

    <!-- ========== EMI CALCULATOR ========== -->
    <div x-show="tab==='emi'" x-cloak x-transition class="mt-8" x-data="emiCalc()">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Inputs -->
        <div class="card lg:col-span-3">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Loan type</label>
              <select x-model="loanType" @change="syncDefaults" class="input-field mt-2">
                <option value="personal">Personal</option>
                <option value="home">Home</option>
                <option value="business">Business</option>
                <option value="gold">Gold</option>
                <option value="lap">Loan Against Property</option>
                <option value="education">Education</option>
                <option value="vehicle">Vehicle</option>
              </select>
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Loan amount</label>
              <div class="mt-2 relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-navy/40 font-semibold">₹</span>
                <input type="number" x-model.number="amount" class="input-field pl-8 nums" min="50000" max="50000000" step="10000">
              </div>
              <input type="range" min="50000" max="20000000" step="50000" x-model.number="amount" class="range-saffron w-full mt-3">
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Interest rate</label>
              <div class="mt-2 relative">
                <input type="number" step="0.1" x-model.number="rate" class="input-field pr-10 nums">
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-navy/40 font-semibold">%</span>
              </div>
              <input type="range" min="5" max="24" step="0.1" x-model.number="rate" class="range-saffron w-full mt-3">
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Tenure (months)</label>
              <input type="number" x-model.number="tenure" class="input-field mt-2 nums" min="3" max="360">
              <input type="range" min="3" max="360" step="3" x-model.number="tenure" class="range-saffron w-full mt-3">
            </div>
          </div>
        </div>

        <!-- Output -->
        <div class="lg:col-span-2 bg-navy text-white rounded-3xl p-7 sm:p-8 relative overflow-hidden grain">
          <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full bg-saffron/30 blur-2xl"></div>
          <div class="relative">
            <div class="text-xs uppercase tracking-[0.18em] text-cream/60 font-semibold">Your monthly EMI</div>
            <div class="mt-3 font-mono text-5xl sm:text-6xl font-bold tracking-tight nums" x-text="'₹' + formatNum(emi)"></div>
            <div class="mt-1 text-sm text-cream/60">on a ₹<span class="nums" x-text="formatNum(amount)"></span> loan</div>

            <div class="mt-7 grid grid-cols-2 gap-3 text-sm">
              <div class="rounded-2xl bg-white/5 p-4 border border-white/10">
                <div class="text-cream/60 text-xs uppercase tracking-wider font-semibold">Total interest</div>
                <div class="font-mono text-xl mt-1 nums" x-text="'₹' + formatNum(totalInterest)"></div>
              </div>
              <div class="rounded-2xl bg-white/5 p-4 border border-white/10">
                <div class="text-cream/60 text-xs uppercase tracking-wider font-semibold">Total payment</div>
                <div class="font-mono text-xl mt-1 nums" x-text="'₹' + formatNum(totalPayment)"></div>
              </div>
            </div>

            <!-- Donut breakdown -->
            <div class="mt-7 flex items-center gap-5">
              <div class="relative w-20 h-20">
                <svg viewBox="0 0 36 36" class="w-20 h-20 -rotate-90">
                  <circle cx="18" cy="18" r="14.4" fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="3"></circle>
                  <circle cx="18" cy="18" r="14.4" fill="none" stroke="#ff8a3d" stroke-width="3"
                          stroke-dasharray="100" :stroke-dashoffset="100 - principalPct" pathLength="100"
                          stroke-linecap="round" style="transition: stroke-dashoffset 400ms ease"></circle>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center text-xs font-bold nums" x-text="principalPct.toFixed(0) + '%'"></div>
              </div>
              <div class="text-xs leading-relaxed text-cream/80">
                <div><span class="inline-block w-2 h-2 rounded-full bg-saffron mr-1.5"></span>Principal</div>
                <div class="mt-1"><span class="inline-block w-2 h-2 rounded-full bg-white/30 mr-1.5"></span>Interest</div>
              </div>
            </div>

            <a href="#lead-form" @click="prefillLeadForm" class="mt-7 btn-primary w-full !justify-between">
              Apply for this loan
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== ELIGIBILITY ========== -->
    <div x-show="tab==='eligibility'" x-cloak x-transition class="mt-8" x-data="eligibilityCheck()">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="card lg:col-span-3">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">I want a</label>
              <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2">
                <template x-for="t in ['personal','home','business','gold','lap','education','vehicle']" :key="t">
                  <button @click="loanType=t"
                          :class="loanType===t ? 'bg-navy text-white border-navy' : 'bg-white text-navy border-navy/10 hover:border-navy/30'"
                          class="text-xs font-bold py-2.5 px-3 rounded-xl border-2 capitalize transition" x-text="t === 'lap' ? 'LAP' : t"></button>
                </template>
              </div>
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Monthly income</label>
              <div class="mt-2 relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-navy/40 font-semibold">₹</span>
                <input type="number" x-model.number="income" class="input-field pl-8 nums" min="0">
              </div>
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Existing monthly EMIs</label>
              <div class="mt-2 relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-navy/40 font-semibold">₹</span>
                <input type="number" x-model.number="existingEmi" class="input-field pl-8 nums" min="0">
              </div>
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Age</label>
              <input type="number" x-model.number="age" class="input-field mt-2 nums" min="18" max="80">
            </div>
            <div>
              <label class="text-xs uppercase tracking-wider font-bold text-navy/55">Credit score</label>
              <select x-model="score" class="input-field mt-2">
                <option value="excellent">750+ (Excellent)</option>
                <option value="good">700–749 (Good)</option>
                <option value="fair">650–699 (Fair)</option>
                <option value="below_650">Below 650</option>
              </select>
            </div>
          </div>
        </div>

        <div class="lg:col-span-2 bg-navy text-white rounded-3xl p-7 sm:p-8 relative overflow-hidden grain">
          <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-saffron/20 blur-2xl"></div>
          <div class="relative">
            <div class="text-xs uppercase tracking-[0.18em] text-cream/60 font-semibold">You're eligible for up to</div>
            <div class="mt-3 font-mono text-5xl sm:text-6xl font-bold tracking-tight nums" x-text="result.eligible ? '₹' + formatNum(result.amount) : '—'"></div>
            <p class="mt-3 text-sm text-cream/75 leading-relaxed" x-text="result.message"></p>
            <a href="#lead-form" x-show="result.eligible" @click="prefillLeadForm" class="mt-7 btn-primary w-full !justify-between">
              Get matched with a lender
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <p class="mt-4 text-[11px] text-cream/40 leading-relaxed">Indicative only. Final eligibility is determined by the lender based on documents and credit history.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== COMPARE ========== -->
    <div x-show="tab==='compare'" x-cloak x-transition class="mt-8">
      <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-cream-100 text-navy/60 uppercase text-xs tracking-wider">
              <tr>
                <th class="text-left px-6 py-4 font-bold">Loan type</th>
                <th class="text-left px-6 py-4 font-bold">Interest from</th>
                <th class="text-left px-6 py-4 font-bold">Tenure</th>
                <th class="text-left px-6 py-4 font-bold">Max amount</th>
                <th class="text-left px-6 py-4 font-bold">Typical approval</th>
                <th class="px-6 py-4"></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-navy/5">
              <?php
              $rows = [
                ['personal','Personal Loan','10.5%','12–60 mo','₹40 L','2–5 days','💼'],
                ['home','Home Loan','8.5%','60–360 mo','₹5 Cr+','7–14 days','🏠'],
                ['business','Business Loan','12%','12–60 mo','₹50 L','5–10 days','📊'],
                ['gold','Gold Loan','9.0%','3–24 mo','75% LTV','Same day','🪙'],
                ['lap','Loan Against Property','9.5%','60–180 mo','₹3 Cr','10–20 days','🏢'],
                ['education','Education Loan','10.0%','60–180 mo','₹50 L','7–21 days','🎓'],
                ['vehicle','Vehicle Loan','9.5%','12–84 mo','85% on-road','2–5 days','🚗'],
              ];
              foreach ($rows as [$slug,$label,$rate,$tenure,$max,$approval,$emoji]): ?>
                <tr class="hover:bg-cream-50 transition">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <span class="text-xl"><?= $emoji ?></span>
                      <span class="font-bold text-navy"><?= e($label) ?></span>
                    </div>
                  </td>
                  <td class="px-6 py-4 font-mono nums font-bold text-saffron-700"><?= e($rate) ?></td>
                  <td class="px-6 py-4 text-navy/70 nums"><?= e($tenure) ?></td>
                  <td class="px-6 py-4 text-navy/70 nums"><?= e($max) ?></td>
                  <td class="px-6 py-4 text-navy/70"><?= e($approval) ?></td>
                  <td class="px-6 py-4 text-right">
                    <a href="#lead-form" data-loan="<?= e($slug) ?>"
                       onclick="window.__leadPrefill='<?= e($slug) ?>'"
                       class="text-saffron-600 font-bold text-sm hover:text-saffron-700 whitespace-nowrap">
                      Apply →
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <p class="mt-4 text-xs text-navy/50 leading-relaxed max-w-3xl">Rates shown are indicative starting rates for well-qualified borrowers. Your offer depends on credit score, income, employer category, and other factors. LoanSathi does not lend — we facilitate matches with our partner lenders.</p>
    </div>
  </div>
</section>

<!-- ========================= LOAN TYPES ========================= -->
<section id="loans" class="py-20 lg:py-28 bg-white relative">
  <div class="container-page">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
      <div class="max-w-xl">
        <span class="eyebrow">Loan types</span>
        <h2 class="h-section mt-3">Pick a loan. <span class="italic font-light text-navy/60">Skip the guesswork.</span></h2>
      </div>
      <p class="text-navy/65 max-w-md text-base">From under-₹1L gold loans to ₹5Cr home loans — we've got a partner lender and a desk consultant for every category.</p>
    </div>

    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <?php
      $loans = [
        ['personal','Personal Loan','Unsecured cash for any need. 12–60 mo.','10.5%','M9 19V8l8-5 8 5v11M9 19v-6h6v6'],
        ['home','Home Loan','Buy, construct, or transfer your home loan.','8.5%','M3 12l9-9 9 9M5 10v10h14V10'],
        ['business','Business Loan','Working capital, equipment, expansion.','12%','M4 20V8M10 20V4M16 20v-8M22 20H2'],
        ['gold','Gold Loan','Quick liquidity against your gold jewellery.','9.0%','M12 2l2.5 5 5.5.8-4 3.9.9 5.4L12 14.8 7.1 17l.9-5.4-4-3.9 5.5-.8z'],
        ['lap','Loan Against Property','Higher amounts, lower rates, longer tenure.','9.5%','M3 20h18M5 20V8l7-4 7 4v12M10 20v-6h4v6'],
        ['education','Education Loan','For India and overseas studies.','10.0%','M3 8l9-4 9 4-9 4-9-4z M5 10v5l7 3 7-3v-5'],
        ['vehicle','Vehicle Loan','Two-wheeler, car, commercial — new or used.','9.5%','M3 13l2-7h14l2 7v5H3z M7 18a2 2 0 100-4 2 2 0 000 4z M17 18a2 2 0 100-4 2 2 0 000 4z'],
        ['callback','Not sure yet?','Talk to a consultant. 24-hour callback.','Free','M21 11c0 4-4 8-9 8a9 9 0 01-3-.5L4 20l1.5-5A8 8 0 013 11c0-4 4-8 9-8s9 4 9 8z'],
      ];
      foreach ($loans as $i => [$slug,$title,$desc,$rate,$path]):
        $href = $slug === 'callback' ? '#lead-form' : "#lead-form";
        $cssClass = $i === count($loans)-1 ? 'bg-navy text-white border-navy' : 'bg-white border-navy/5 hover:border-saffron text-navy';
      ?>
        <a href="<?= e($href) ?>"
           onclick="<?= $slug !== 'callback' ? "window.__leadPrefill='".e($slug)."'" : '' ?>"
           class="group relative <?= $cssClass ?> rounded-3xl border-2 p-6 transition hover:-translate-y-1 hover:shadow-deep">
          <div class="<?= $slug === 'callback' ? 'text-saffron' : 'text-navy/40 group-hover:text-saffron-600' ?> transition">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="w-9 h-9">
              <path d="<?= $path ?>" stroke-linejoin="round" stroke-linecap="round"/>
            </svg>
          </div>
          <h3 class="mt-5 font-display text-xl font-semibold <?= $slug === 'callback' ? 'text-white' : 'text-navy' ?>"><?= e($title) ?></h3>
          <p class="mt-2 text-sm <?= $slug === 'callback' ? 'text-cream/70' : 'text-navy/60' ?> leading-relaxed"><?= e($desc) ?></p>
          <div class="mt-5 flex items-center justify-between">
            <span class="font-mono text-xs uppercase tracking-wider font-bold <?= $slug === 'callback' ? 'text-saffron' : 'text-saffron-700' ?>">
              <?= $slug === 'callback' ? '' : 'from ' ?><?= e($rate) ?>
            </span>
            <span class="inline-flex items-center gap-1 text-xs font-bold <?= $slug === 'callback' ? 'text-white' : 'text-navy/60 group-hover:text-saffron-600' ?> transition">
              <?= $slug === 'callback' ? 'Talk to us' : 'Apply' ?>
              <svg viewBox="0 0 24 24" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= HOW IT WORKS ========================= -->
<section id="how-it-works" class="py-20 lg:py-28 bg-cream-50 relative overflow-hidden">
  <div class="absolute -bottom-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-saffron/8 blur-3xl"></div>
  <div class="container-page relative">
    <div class="max-w-xl">
      <span class="eyebrow">How it works</span>
      <h2 class="h-section mt-3">Three steps. <span class="italic font-light text-navy/60">No paperwork until you're matched.</span></h2>
    </div>

    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6">
      <?php foreach ([
        ['01','Tell us what you need','60 seconds. Loan type, amount, your monthly income. That\'s the form.'],
        ['02','We compare lenders','We screen 20+ banks &amp; NBFCs, factoring your credit profile and employer category.'],
        ['03','Pick from 3 offers','A consultant calls within 24 hours with three tailored offers. You pick the one you like — or none.'],
      ] as $i => [$n,$t,$d]): ?>
        <div class="relative animate-fade-up" style="animation-delay: <?= $i * 80 ?>ms">
          <div class="font-display text-7xl text-saffron/20 font-semibold leading-none nums"><?= $n ?></div>
          <h3 class="mt-3 font-display text-2xl text-navy"><?= $t ?></h3>
          <p class="mt-2 text-navy/65 leading-relaxed"><?= $d ?></p>
          <?php if ($i < 2): ?>
            <div class="hidden md:block absolute top-8 -right-3 text-navy/15">
              <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= TESTIMONIALS ========================= -->
<section class="py-20 lg:py-28 bg-white">
  <div class="container-page">
    <div class="max-w-xl">
      <span class="eyebrow">Borrowers, on the record</span>
      <h2 class="h-section mt-3">2,000+ matched. <span class="italic font-light text-navy/60">Here's a few.</span></h2>
    </div>

    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php foreach ([
        ['Aman K., Bengaluru', 'Got my home loan in 9 days — and 0.4% lower than my own bank offered. The consultant explained everything in plain Hindi.', 'Home loan · ₹62 L · HDFC', 'AK', 'bg-saffron'],
        ['Priya S., Mumbai', 'Ran the EMI calculator on the homepage, saw I was over-paying my old loan. Took a balance-transfer through them — saved ₹4.2 L over the tenure.', 'Balance transfer · ₹18 L · Axis', 'PS', 'bg-navy'],
        ['Rahul J., Pune', 'New business, no income proof, every bank said no. LoanSathi found me a Bajaj line in 6 days. Zero paperwork chaos.', 'Business loan · ₹15 L · Bajaj', 'RJ', 'bg-brand-blue'],
      ] as [$name,$quote,$meta,$initials,$bg]): ?>
        <figure class="card relative">
          <svg viewBox="0 0 24 24" class="absolute top-6 right-6 w-8 h-8 text-saffron/25" fill="currentColor">
            <path d="M9 7H5v6h4l-2 4h3l2-4V7zm10 0h-4v6h4l-2 4h3l2-4V7z"/>
          </svg>
          <div class="flex items-center gap-3">
            <span class="w-11 h-11 rounded-full <?= $bg ?> text-white font-display font-semibold inline-flex items-center justify-center text-sm"><?= $initials ?></span>
            <div>
              <div class="font-bold text-navy text-sm"><?= e($name) ?></div>
              <div class="text-xs text-saffron-600">★★★★★</div>
            </div>
          </div>
          <blockquote class="mt-4 text-navy/80 leading-relaxed">"<?= $quote ?>"</blockquote>
          <figcaption class="mt-5 pt-4 border-t border-navy/5 text-xs text-navy/50 nums"><?= e($meta) ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= FAQ ========================= -->
<section id="faq" class="py-20 lg:py-28 bg-cream-50">
  <div class="container-tight">
    <span class="eyebrow">FAQ</span>
    <h2 class="h-section mt-3">Common questions. <span class="italic font-light text-navy/60">Short answers.</span></h2>

    <div class="mt-10 space-y-3" x-data="{ open: 0 }">
      <?php foreach ([
        ['Is LoanSathi free for borrowers?','Yes. We are paid a fee by the lender only when your loan is disbursed. You never pay us anything.'],
        ['What credit score do I need?','Most personal/home loans need 700+. We work with lenders who accept 650+ for select cases and gold/LAP options exist even for thinner profiles.'],
        ['How fast is disbursement?','Personal loans: 2–5 days. Gold loans: same day. Home loans: 7–14 days. The exact timeline depends on documentation completeness.'],
        ['Will I receive spam calls?','No. Your details are shared only with the 1–3 lenders matched to your profile, and only after you confirm by phone with our consultant.'],
        ['Can I get a loan without ITR?','Yes — gold loans, LAP, and many business loans accept alternative income proof. Tell the consultant your situation and they\'ll route appropriately.'],
      ] as $i => [$q,$a]): ?>
        <div class="bg-white rounded-2xl border border-navy/5 overflow-hidden">
          <button @click="open = open === <?= $i ?> ? -1 : <?= $i ?>"
                  class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-semibold text-navy text-base sm:text-lg"><?= e($q) ?></span>
            <span :class="open === <?= $i ?> ? 'rotate-180' : ''" class="text-saffron-600 transition-transform shrink-0">
              <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
            </span>
          </button>
          <div x-show="open === <?= $i ?>" x-collapse x-cloak class="px-6 pb-5 text-navy/70 leading-relaxed"><?= $a ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= LEAD CTA ========================= -->
<section class="py-20 lg:py-28 bg-navy text-white relative overflow-hidden grain">
  <div class="absolute inset-0 bg-grid bg-[length:48px_48px] opacity-10 pointer-events-none"></div>
  <div class="absolute -top-40 left-1/4 w-[36rem] h-[36rem] rounded-full bg-radial-amber opacity-80 pointer-events-none"></div>

  <div class="container-page relative">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
      <div class="lg:col-span-7">
        <span class="chip-dark">Step 1 of 1</span>
        <h2 class="mt-5 font-display text-4xl sm:text-5xl lg:text-6xl leading-[1.02] font-semibold">
          Drop your number.<br>
          <span class="italic font-light text-cream">We'll do the running around.</span>
        </h2>
        <ul class="mt-8 space-y-3 text-cream/80 text-base">
          <?php foreach ([
            'Free, no-obligation consultation',
            'Hand-picked offers from 20+ lenders',
            'Faster approvals with pre-screened profiles',
            'Available in English, हिंदी, ಕನ್ನಡ, தமிழ், తెలుగు',
          ] as $b): ?>
            <li class="flex items-start gap-3">
              <svg viewBox="0 0 24 24" class="w-5 h-5 text-saffron shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 13l4 4L19 7"/></svg>
              <span><?= e($b) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="mt-10 pt-8 border-t border-white/10 text-sm text-cream/55">
          Prefer to chat? <a class="text-saffron font-bold hover:text-saffron-400" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>" target="_blank" rel="noopener">WhatsApp us →</a>
          &nbsp; or call <a class="text-white font-bold" href="tel:<?= e(config('contact.phone')) ?>"><?= e(config('contact.phone_display')) ?></a>
        </div>
      </div>

      <div class="lg:col-span-5">
        <?php require __DIR__ . '/../partials/lead-form.php'; ?>
      </div>
    </div>
  </div>
</section>

<script>
function emiCore(P, R, N) {
  if (P <= 0 || N <= 0) return 0;
  if (R === 0) return P / N;
  const r = R / 12 / 100;
  const pow = Math.pow(1 + r, N);
  return (P * r * pow) / (pow - 1);
}

function emiHero() {
  return {
    amount: 1500000,
    rate: 9.5,
    tenure: 60,
    get emi() { return emiCore(this.amount, this.rate, this.tenure); },
    formatINR(n, abbrev) {
      if (abbrev) {
        if (n >= 10000000) return '₹' + (n/10000000).toFixed(2) + ' Cr';
        if (n >= 100000) return '₹' + (n/100000).toFixed(1) + ' L';
        return '₹' + Math.round(n).toLocaleString('en-IN');
      }
      return Math.round(n).toLocaleString('en-IN');
    },
    formatNum(n) {
      if (n >= 10000000) return (n/10000000).toFixed(2) + ' Cr';
      if (n >= 100000) return (n/100000).toFixed(1) + ' L';
      return Math.round(n).toLocaleString('en-IN');
    }
  };
}

const RATE_DEFAULTS = {
  personal: 10.5, home: 8.5, business: 12, gold: 9, lap: 9.5, education: 10, vehicle: 9.5
};
const TENURE_DEFAULTS = {
  personal: 36, home: 240, business: 36, gold: 12, lap: 120, education: 84, vehicle: 60
};
const AMOUNT_DEFAULTS = {
  personal: 500000, home: 5000000, business: 1500000, gold: 300000, lap: 3000000, education: 1500000, vehicle: 800000
};

function emiCalc() {
  return {
    loanType: 'personal',
    amount: 500000,
    rate: 10.5,
    tenure: 36,
    syncDefaults() {
      this.amount = AMOUNT_DEFAULTS[this.loanType];
      this.rate = RATE_DEFAULTS[this.loanType];
      this.tenure = TENURE_DEFAULTS[this.loanType];
    },
    get emi() { return Math.round(emiCore(this.amount, this.rate, this.tenure)); },
    get totalPayment() { return this.emi * this.tenure; },
    get totalInterest() { return Math.max(0, this.totalPayment - this.amount); },
    get principalPct() { return this.totalPayment > 0 ? (this.amount / this.totalPayment) * 100 : 0; },
    formatNum(n) {
      return Math.round(n).toLocaleString('en-IN');
    },
    prefillLeadForm() {
      window.__leadPrefill = this.loanType;
      window.__leadAmount = this.amount;
    }
  };
}

function eligibilityCheck() {
  return {
    loanType: 'personal',
    income: 60000,
    existingEmi: 0,
    age: 30,
    score: 'good',
    get result() {
      const inc = +this.income || 0;
      const emi = +this.existingEmi || 0;
      if (inc <= 0) return { eligible: false, amount: 0, message: 'Enter your monthly income to see eligibility.' };

      let amount = 0, eligible = false, message = '';
      switch (this.loanType) {
        case 'personal': {
          if (this.age < 21 || this.age > 60) { message = 'Age must be 21–60 for personal loans.'; break; }
          if (this.score === 'below_650') { message = 'Score below 650 typically disqualifies personal loans. Try gold/LAP instead.'; break; }
          const capacity = 24 * inc - 12 * emi;
          if (capacity <= 0) { message = 'Existing EMIs leave no repayment headroom.'; break; }
          amount = capacity; eligible = true;
          message = 'Based on your income & EMI capacity. Final offer depends on credit history.';
          break;
        }
        case 'home': {
          const maxEmi = inc * 0.55 - emi;
          if (maxEmi <= 0) { message = 'Existing EMIs leave no headroom for a home loan.'; break; }
          const r = 8.5 / 12 / 100, n = 240, pow = Math.pow(1+r, n);
          amount = maxEmi * (pow - 1) / (r * pow);
          eligible = true; message = 'Assumes 8.5% over 20 years. Longer tenure increases the eligible amount.';
          break;
        }
        case 'business': amount = inc * 12 * 0.30 * 10; eligible = inc > 0; message = 'Indicative — based on 30% of annual turnover (≈ income × 12).'; break;
        case 'gold': amount = 4500000; eligible = true; message = 'Gold loans depend on pledged weight × value × 75% LTV. Talk to a consultant for an exact number.'; break;
        case 'lap': amount = 6500000; eligible = true; message = 'Loan Against Property typically goes up to 65% of property value.'; break;
        case 'education': amount = this.score === 'below_650' ? 750000 : 5000000; eligible = true; message = 'Without collateral, capped at ₹7.5L. With collateral or co-applicant, up to ₹50L.'; break;
        case 'vehicle': amount = 680000; eligible = true; message = 'Up to 85% of on-road price. Some lenders cover 90% on select models.'; break;
      }
      return { eligible, amount: Math.round(amount), message };
    },
    formatNum(n) {
      if (n >= 10000000) return (n/10000000).toFixed(2) + ' Cr';
      if (n >= 100000) return (n/100000).toFixed(1) + ' L';
      return Math.round(n).toLocaleString('en-IN');
    },
    prefillLeadForm() {
      window.__leadPrefill = this.loanType;
      window.__leadAmount = this.result.amount;
    }
  };
}

// Wire prefill into the lead form once Alpine inits it
document.addEventListener('alpine:init', () => {
  setTimeout(() => {
    document.querySelectorAll('a[href="#lead-form"]').forEach(a => {
      a.addEventListener('click', () => {
        const lt = window.__leadPrefill;
        if (!lt) return;
        const root = document.getElementById('lead-form');
        if (!root || !root.__x) return;
        const data = root.__x.$data;
        if (data && data.form) {
          if (RATE_DEFAULTS[lt]) data.form.loan_type = lt;
          if (window.__leadAmount && data.form.loan_type) data.form.loan_amount = window.__leadAmount;
        }
      });
    });
  }, 300);
});
</script>

<?php require __DIR__ . '/../partials/footer.php'; ?>
