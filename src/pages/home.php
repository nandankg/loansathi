<?php
$page_title = 'InstantPersonalLoan — Compare loans, calculate EMI, get matched in 24 hours';
$page_description = 'India\'s smart loan companion. Compare personal, home, business, gold and other loans from 20+ lenders. Instant EMI calculator and eligibility checker. Free expert guidance, no fees from you.';
require __DIR__ . '/../partials/header.php';
?>

<!-- ========================= HERO ========================= -->
<section class="relative overflow-hidden bg-gradient-to-br from-surface-100 via-white to-surface-100">
  <!-- decorative blobs -->
  <div class="absolute -top-32 -right-20 w-[40rem] h-[40rem] rounded-full bg-glow-blue pointer-events-none"></div>
  <div class="absolute -bottom-20 -left-32 w-[28rem] h-[28rem] rounded-full bg-glow-orange pointer-events-none"></div>
  <!-- dotted decoration top-left -->
  <div class="absolute top-12 left-6 w-24 h-24 text-brand-500/30 dotted pointer-events-none hidden sm:block"></div>
  <!-- dotted decoration bottom-right -->
  <div class="absolute bottom-12 right-6 w-24 h-24 text-accent-500/25 dotted pointer-events-none hidden sm:block"></div>

  <div class="container-page relative pt-12 pb-16 lg:pt-16 lg:pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
      <!-- LEFT: copy -->
      <div class="lg:col-span-7 animate-fade-up">
        <div class="flex items-center gap-2 flex-wrap">
          <span class="chip-success"><span class="w-1.5 h-1.5 rounded-full bg-success-500 animate-pulse-soft"></span> 2,000+ loans facilitated</span>
          <span class="chip-brand">★ 4.8/5 from borrowers</span>
        </div>
        <h1 class="mt-6 h-hero">
          Check Your
          <span class="block text-brand-500">Loan Eligibility</span>
          <span class="block text-accent-500">in 60 seconds.</span>
        </h1>
        <p class="mt-7 max-w-xl text-lg text-ink-500 leading-relaxed">
          Tell us once. We compare offers from <strong class="text-ink">20+ banks &amp; NBFCs</strong>, pre-check your eligibility, and route the best three to your phone — no spam, no fees from you.
        </p>
        <div class="mt-8 flex flex-wrap gap-3">
          <a href="#tools" class="btn-accent text-base">
            Try Calculators
            <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg>
          </a>
          <a href="#lead-form" class="btn-primary text-base">
            Check Eligibility
          </a>
        </div>
        <div class="mt-10 grid grid-cols-3 gap-6 max-w-xl">
          <div>
            <div class="font-display text-3xl text-brand-500 font-extrabold nums">8.5%</div>
            <div class="text-xs uppercase tracking-wider text-ink-500 font-bold mt-1">Home loan from</div>
          </div>
          <div>
            <div class="font-display text-3xl text-accent-500 font-extrabold nums">₹5Cr</div>
            <div class="text-xs uppercase tracking-wider text-ink-500 font-bold mt-1">Max disbursed</div>
          </div>
          <div>
            <div class="font-display text-3xl text-success-500 font-extrabold nums">20+</div>
            <div class="text-xs uppercase tracking-wider text-ink-500 font-bold mt-1">Lender partners</div>
          </div>
        </div>
      </div>

      <!-- RIGHT: phone mockup with live EMI -->
      <div class="lg:col-span-5 animate-fade-up" style="animation-delay:120ms" x-data="emiHero()">
        <div class="relative max-w-[340px] mx-auto">
          <!-- floating glow background -->
          <div class="absolute -inset-8 bg-brand-500/10 rounded-full blur-3xl"></div>
          <div class="absolute -top-6 -right-10 w-32 h-32 rounded-full bg-accent-500/20 blur-2xl"></div>
          <!-- decorative ring -->
          <div class="absolute -top-8 -left-8 w-16 h-16 rounded-full border-2 border-brand-500/20 animate-spin-slow"></div>
          <!-- floating tag -->
          <div class="absolute -top-3 -right-3 z-10 bg-success-500 text-white text-[11px] font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-card animate-float">
            ✓ Live preview
          </div>

          <!-- phone frame -->
          <div class="phone-frame relative" style="width:340px; height:680px;">
            <div class="phone-screen h-full p-5 pt-10 flex flex-col">
              <!-- App header inside phone -->
              <div class="flex items-center justify-between text-[10px] text-ink-400 nums">
                <span>9:41</span>
                <div class="flex items-center gap-1">
                  <svg viewBox="0 0 24 24" class="w-3 h-3" fill="currentColor"><path d="M1 9l2 2c5-5 13-5 18 0l2-2C16 2 8 2 1 9z"/></svg>
                  <svg viewBox="0 0 24 24" class="w-3 h-3" fill="currentColor"><rect x="2" y="6" width="18" height="12" rx="2"/></svg>
                </div>
              </div>

              <div class="mt-3 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 text-white">
                  <svg viewBox="0 0 24 24" fill="none" class="w-4 h-4"><path d="M3 17l5-5 4 4 8-8" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <span class="font-display text-base font-extrabold text-ink leading-none">Loan<span class="text-accent-500">Sathi</span></span>
              </div>

              <div class="mt-4 text-[10px] uppercase tracking-widest font-extrabold text-ink-400">Your monthly EMI</div>
              <div class="mt-1 font-mono text-4xl font-extrabold nums text-ink" x-text="'₹' + formatINR(emi)">₹31,541</div>
              <p class="text-[11px] text-ink-400 mt-1">at <span x-text="rate.toFixed(1)">9.5</span>% for <span x-text="tenure">60</span> months on <span x-text="formatAbbrev(amount)">₹15.0 L</span></p>

              <!-- breakdown bar -->
              <div class="mt-4 h-2 rounded-full bg-surface-100 overflow-hidden flex">
                <div class="bg-brand-500" :style="'width:' + principalPct + '%'"></div>
                <div class="bg-accent-500" :style="'width:' + (100-principalPct) + '%'"></div>
              </div>
              <div class="mt-2 flex items-center justify-between text-[10px] text-ink-500">
                <span><span class="inline-block w-2 h-2 rounded-full bg-brand-500"></span> Principal</span>
                <span><span class="inline-block w-2 h-2 rounded-full bg-accent-500"></span> Interest</span>
              </div>

              <!-- sliders -->
              <div class="mt-5 space-y-4 flex-1">
                <label class="block">
                  <div class="flex justify-between text-[11px] font-bold text-ink-500 mb-1.5">
                    <span>Loan amount</span><span class="nums text-ink font-extrabold" x-text="formatAbbrev(amount)">₹15.0 L</span>
                  </div>
                  <input type="range" min="100000" max="10000000" step="50000" x-model.number="amount" class="range-brand w-full">
                </label>
                <label class="block">
                  <div class="flex justify-between text-[11px] font-bold text-ink-500 mb-1.5">
                    <span>Interest rate</span><span class="nums text-ink font-extrabold" x-text="rate.toFixed(1) + '% p.a.'">9.5% p.a.</span>
                  </div>
                  <input type="range" min="6" max="22" step="0.1" x-model.number="rate" class="range-brand w-full">
                </label>
                <label class="block">
                  <div class="flex justify-between text-[11px] font-bold text-ink-500 mb-1.5">
                    <span>Tenure</span><span class="nums text-ink font-extrabold" x-text="tenure + ' mo'">60 mo</span>
                  </div>
                  <input type="range" min="6" max="360" step="6" x-model.number="tenure" class="range-brand w-full">
                </label>
              </div>

              <a href="#lead-form" class="mt-4 btn-accent w-full !py-3 !text-sm">Apply Now</a>
              <p class="mt-2 text-center text-[10px] text-ink-400">Indicative figures · Final offer from lender</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================= TRUST BADGES ========================= -->
<section class="border-y border-ink/5 bg-white py-8">
  <div class="container-page">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
      <?php
      $badges = [
        ['100% Secure',         'and Safe',         'success', 'M12 2L3 7v6c0 5 4 8 9 9 5-1 9-4 9-9V7l-9-5z M9 12l2 2 4-4'],
        ['Quick',               '&amp; Easy',       'brand',   'M12 2v4 M12 18v4 M2 12h4 M18 12h4 M12 12l4 4 M12 8a4 4 0 100 8 4 4 0 000-8z'],
        ['Better Decisions',    'Better Future',    'accent',  'M3 17l5-5 4 4 8-8 M16 8h4v4'],
        ['Privacy',             'Protected',       'brand',   'M6 10V7a6 6 0 1112 0v3 M5 10h14v10H5z M12 14v3'],
      ];
      foreach ($badges as [$title, $sub, $color, $path]):
        $bg = $color === 'success' ? 'bg-success-50 text-success-500' : ($color === 'accent' ? 'bg-accent-50 text-accent-500' : 'bg-brand-50 text-brand-500');
      ?>
        <div class="flex items-center gap-4">
          <span class="icon-badge <?= $bg ?> shrink-0">
            <svg viewBox="0 0 24 24" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="<?= $path ?>"/>
            </svg>
          </span>
          <div class="text-sm">
            <div class="font-extrabold text-ink leading-tight"><?= $title ?></div>
            <div class="text-ink-500 leading-tight"><?= $sub ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= LENDER STRIP ========================= -->
<section class="bg-surface-100 py-6 border-b border-ink/5">
  <div class="container-page flex items-center gap-6 flex-wrap">
    <div class="text-[11px] uppercase tracking-[0.2em] text-ink-500 font-extrabold whitespace-nowrap">Lender Partners</div>
    <div class="flex-1 flex flex-wrap items-center gap-x-8 gap-y-3 text-ink-500 text-base font-bold">
      <span>HDFC Bank</span>
      <span>ICICI</span>
      <span>Axis Bank</span>
      <span>Bajaj Finserv</span>
      <span>Tata Capital</span>
      <span>SBI</span>
      <span>Kotak</span>
      <span class="text-accent-500">+ 13 more →</span>
    </div>
  </div>
</section>

<!-- ========================= TOOLS HUB ========================= -->
<section id="tools" class="py-20 lg:py-28 bg-white relative overflow-hidden" x-data="{ tab: 'emi' }">
  <div class="absolute top-0 right-0 w-80 h-80 -mr-32 -mt-32 rounded-full bg-brand-500/8 blur-3xl"></div>
  <div class="absolute bottom-0 left-0 w-72 h-72 -ml-32 -mb-32 rounded-full bg-accent-500/8 blur-3xl"></div>

  <div class="container-page relative">
    <div class="text-center max-w-2xl mx-auto">
      <span class="eyebrow">Free tools, no sign-up</span>
      <h2 class="h-section mt-3">Math first. <span class="text-gradient-accent">Forms later.</span></h2>
      <p class="mt-4 text-ink-500 text-lg">Run the numbers right here, then ask for a callback only when it makes sense.</p>
    </div>

    <!-- Tab nav -->
    <div class="mt-10 flex justify-center">
      <div class="inline-flex flex-wrap gap-1 p-1.5 rounded-full bg-surface-100 border border-ink/5 shadow-card">
        <button type="button" data-tool-tab="emi" @click="tab='emi'" class="tool-tab active" :class="{ 'active': tab==='emi' }">
          EMI Calculator
        </button>
        <button type="button" data-tool-tab="eligibility" @click="tab='eligibility'" class="tool-tab" :class="{ 'active': tab==='eligibility' }">
          Eligibility
        </button>
        <button type="button" data-tool-tab="compare" @click="tab='compare'" class="tool-tab" :class="{ 'active': tab==='compare' }">
          Compare
        </button>
      </div>
    </div>

    <!-- ========== EMI CALCULATOR ========== -->
    <div id="emi-tool" data-tool-panel="emi" x-show="tab==='emi'" x-cloak x-transition class="mt-10" x-data="emiCalc()">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="card lg:col-span-3">
          <div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
              <span class="eyebrow">EMI Calculator</span>
              <h3 class="mt-3 font-display text-3xl font-extrabold text-ink">Plan your monthly payment</h3>
              <p class="mt-2 text-sm text-ink-500">Enter amount, rate, and tenure, then calculate your EMI instantly.</p>
            </div>
            <span class="chip-brand w-fit">Instant estimate</span>
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
          <div class="absolute top-4 right-4 w-16 h-16 text-white/15 dotted"></div>
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

            <a href="#lead-form" @click="prefillLeadForm" class="mt-7 btn-accent w-full !justify-between">
              Apply for this loan
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== ELIGIBILITY ========== -->
    <div id="eligibility-tool" data-tool-panel="eligibility" x-show="tab==='eligibility'" x-cloak x-transition class="mt-10" x-data="eligibilityCheck()">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="card lg:col-span-3">
          <div class="mb-7 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
              <span class="eyebrow">Eligibility Checker</span>
              <h3 class="mt-3 font-display text-3xl font-extrabold text-ink">Check how much you may qualify for</h3>
              <p class="mt-2 text-sm text-ink-500">Add your income, existing EMI, age, and credit range to estimate eligibility.</p>
            </div>
            <span class="chip-success w-fit">No signup needed</span>
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
            <div class="text-[11px] uppercase tracking-[0.2em] text-white/70 font-extrabold">You're eligible for up to</div>
            <div class="mt-3 font-mono text-5xl sm:text-6xl font-extrabold tracking-tight nums" data-elig-result="amount" x-text="result.eligible ? '₹' + formatNum(result.amount) : '—'">₹14.4 L</div>
            <p class="mt-3 text-sm text-white/80 leading-relaxed" data-elig-result="message" x-text="result.message">Based on your income and EMI capacity. Final offer depends on credit history.</p>
            <a href="#lead-form" x-show="result.eligible" @click="prefillLeadForm" class="mt-7 btn-accent w-full !justify-between">
              Get matched with a lender
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
            <p class="mt-4 text-[11px] text-white/50 leading-relaxed">Indicative only. Final eligibility is determined by the lender based on documents and credit history.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ========== COMPARE ========== -->
    <div data-tool-panel="compare" x-show="tab==='compare'" x-cloak x-transition class="mt-10">
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
                    <a href="#lead-form" onclick="window.__leadPrefill='<?= e($slug) ?>'" class="text-brand-500 font-extrabold text-sm hover:text-brand-700 whitespace-nowrap">
                      Apply →
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <p class="mt-4 text-xs text-ink-500 leading-relaxed max-w-3xl">Rates shown are indicative starting rates for well-qualified borrowers. Your offer depends on credit score, income, employer category, and other factors. LoanSathi does not lend — we facilitate matches with our partner lenders.</p>
    </div>
  </div>
</section>

<!-- ========================= LOAN TYPES ========================= -->
<section id="loans" class="py-20 lg:py-28 bg-surface-100 relative">
  <div class="container-page">
    <div class="text-center max-w-2xl mx-auto">
      <span class="eyebrow">Loan Categories</span>
      <h2 class="h-section mt-3">Pick a loan. <span class="text-gradient-brand">Skip the guesswork.</span></h2>
      <p class="mt-4 text-ink-500 text-base">From under-₹1L gold loans to ₹5Cr home loans — we've got a partner lender and a desk consultant for every category.</p>
    </div>

    <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <?php
      $loans = [
        ['personal','Personal Loan','Unsecured cash for any need.','10.5%','brand',   'M9 7h6l2 13H7L9 7z M10 7V4h4v3'],
        ['home','Home Loan','Buy, build, or transfer.','8.5%','accent', 'M3 12l9-9 9 9 M5 10v10h14V10'],
        ['business','Business Loan','Working capital & expansion.','12%','success', 'M4 20V8 M10 20V4 M16 20v-8 M22 20H2'],
        ['gold','Gold Loan','Quick cash against jewellery.','9.0%','accent', 'M12 2l2.5 5 5.5.8-4 3.9.9 5.4L12 14.8 7.1 17l.9-5.4-4-3.9 5.5-.8z'],
        ['lap','Loan Against Property','Higher amounts, lower rates.','9.5%','brand',  'M3 20h18 M5 20V8l7-4 7 4v12 M10 20v-6h4v6'],
        ['education','Education Loan','India & overseas studies.','10.0%','success', 'M3 8l9-4 9 4-9 4-9-4z M5 10v5l7 3 7-3v-5'],
        ['vehicle','Vehicle Loan','Car, two-wheeler, commercial.','9.5%','accent', 'M3 13l2-7h14l2 7v5H3z M7 18a2 2 0 100-4 2 2 0 000 4z M17 18a2 2 0 100-4 2 2 0 000 4z'],
        ['callback','Not sure yet?','Talk to a consultant. 24-hr callback.','Free','dark', 'M21 11c0 4-4 8-9 8a9 9 0 01-3-.5L4 20l1.5-5A8 8 0 013 11c0-4 4-8 9-8s9 4 9 8z'],
      ];
      foreach ($loans as $i => [$slug,$title,$desc,$rate,$color,$path]):
        if ($color === 'dark') {
          $tileClass = 'bg-gradient-to-br from-ink-900 to-brand-700 border-transparent text-white';
          $iconBg = 'bg-white/15 text-white';
          $rateColor = 'text-accent-500';
          $titleColor = 'text-white';
          $descColor = 'text-white/70';
          $arrowColor = 'text-accent-500';
        } else {
          $tileClass = 'bg-white border-ink/5 text-ink';
          $iconBg = ($color === 'success' ? 'bg-success-50 text-success-500' : ($color === 'accent' ? 'bg-accent-50 text-accent-500' : 'bg-brand-50 text-brand-500'));
          $rateColor = 'text-accent-500';
          $titleColor = 'text-ink';
          $descColor = 'text-ink-500';
          $arrowColor = 'text-ink-500 group-hover:text-brand-500';
        }
      ?>
        <a href="#lead-form"
           onclick="<?= $slug !== 'callback' ? "window.__leadPrefill='".e($slug)."'" : '' ?>"
           class="group relative <?= $tileClass ?> rounded-3xl border-2 p-6 transition hover:-translate-y-1 hover:shadow-deep">
          <span class="icon-badge <?= $iconBg ?>">
            <svg viewBox="0 0 24 24" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="<?= $path ?>"/>
            </svg>
          </span>
          <h3 class="mt-5 font-display text-lg font-extrabold <?= $titleColor ?>"><?= e($title) ?></h3>
          <p class="mt-1 text-sm <?= $descColor ?> leading-relaxed"><?= e($desc) ?></p>
          <div class="mt-5 flex items-center justify-between">
            <span class="font-mono text-xs uppercase tracking-wider font-extrabold <?= $rateColor ?>">
              <?= $slug === 'callback' ? '' : 'from ' ?><?= e($rate) ?>
            </span>
            <span class="inline-flex items-center gap-1 text-xs font-extrabold <?= $arrowColor ?> transition">
              <?= $slug === 'callback' ? 'Talk →' : 'Apply' ?>
              <svg viewBox="0 0 24 24" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= HOW IT WORKS ========================= -->
<section id="how-it-works" class="py-20 lg:py-28 bg-white relative overflow-hidden">
  <div class="absolute -bottom-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-accent-500/8 blur-3xl"></div>
  <div class="container-page relative">
    <div class="text-center max-w-2xl mx-auto">
      <span class="eyebrow">How it works</span>
      <h2 class="h-section mt-3">Three steps. <span class="text-gradient-accent">Loan in hand.</span></h2>
      <p class="mt-4 text-ink-500 text-base">No paperwork chaos. No spam calls. Just clean matchmaking between you and the right lender.</p>
    </div>

    <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
      <?php foreach ([
        ['01','Tell us what you need','60 seconds. Loan type, amount, your monthly income. That\'s the form.','M9 11l3 3L22 4 M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11','brand'],
        ['02','We compare lenders','We screen 20+ banks &amp; NBFCs, factoring your credit profile and employer category.','M6 12h12 M6 6h12 M6 18h6 M16 16l4 4 M16 20l4-4','accent'],
        ['03','Pick from 3 offers','A consultant calls within 24 hours with three tailored offers. You pick the one you like.','M20 6L9 17l-5-5','success'],
      ] as $i => [$n,$t,$d,$path,$color]):
        $bg = $color === 'success' ? 'bg-success-50 text-success-500' : ($color === 'accent' ? 'bg-accent-50 text-accent-500' : 'bg-brand-50 text-brand-500');
      ?>
        <div class="relative animate-fade-up" style="animation-delay: <?= $i * 80 ?>ms">
          <div class="card hover:-translate-y-1 transition">
            <div class="flex items-start justify-between">
              <span class="icon-badge <?= $bg ?>">
                <svg viewBox="0 0 24 24" class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="<?= $path ?>"/>
                </svg>
              </span>
              <span class="font-display text-6xl font-extrabold text-ink/10 leading-none nums"><?= $n ?></span>
            </div>
            <h3 class="mt-5 font-display text-xl font-extrabold text-ink"><?= $t ?></h3>
            <p class="mt-2 text-ink-500 leading-relaxed"><?= $d ?></p>
          </div>
          <?php if ($i < 2): ?>
            <div class="hidden md:flex absolute top-1/2 -right-5 -translate-y-1/2 w-10 h-10 rounded-full bg-white border-2 border-ink/5 items-center justify-center text-ink/30 z-10">
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= TESTIMONIALS ========================= -->
<section class="py-20 lg:py-28 bg-surface-100">
  <div class="container-page">
    <div class="text-center max-w-2xl mx-auto">
      <span class="eyebrow">Borrowers, on the record</span>
      <h2 class="h-section mt-3">2,000+ matched. <span class="text-gradient-brand">Here's a few.</span></h2>
    </div>

    <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-6">
      <?php
      $testimonials = [
        ['Aman Kumar','Bengaluru','Got my home loan in 9 days — and 0.4% lower than my own bank offered. The consultant explained everything in plain Hindi.','Home loan · ₹62 L · HDFC','1e62d7'],
        ['Priya Sharma','Mumbai','Ran the EMI calculator on the homepage, saw I was over-paying my old loan. Took a balance-transfer through them — saved ₹4.2 L over the tenure.','Balance transfer · ₹18 L · Axis','ff6b35'],
        ['Rahul Joshi','Pune','New business, no income proof, every bank said no. LoanSathi found me a Bajaj line in 6 days. Zero paperwork chaos.','Business loan · ₹15 L · Bajaj','16a34a'],
      ];
      foreach ($testimonials as [$name,$city,$quote,$meta,$color]):
        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=' . $color . '&color=fff&size=128&bold=true&font-size=0.42';
      ?>
        <figure class="card relative">
          <svg viewBox="0 0 24 24" class="absolute top-6 right-6 w-10 h-10 text-accent-500/20" fill="currentColor">
            <path d="M9 7H5v6h4l-2 4h3l2-4V7zm10 0h-4v6h4l-2 4h3l2-4V7z"/>
          </svg>
          <div class="flex items-center gap-3">
            <img src="<?= e($avatarUrl) ?>" alt="<?= e($name) ?>" loading="lazy" class="w-12 h-12 rounded-full shadow-card" width="48" height="48">
            <div>
              <div class="font-extrabold text-ink text-sm leading-tight"><?= e($name) ?></div>
              <div class="text-xs text-ink-500"><?= e($city) ?></div>
              <div class="text-xs text-accent-500 mt-0.5">★★★★★</div>
            </div>
          </div>
          <blockquote class="mt-4 text-ink-700 leading-relaxed">"<?= $quote ?>"</blockquote>
          <figcaption class="mt-5 pt-4 border-t border-ink/5 text-xs text-ink-500 nums font-semibold"><?= e($meta) ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= FAQ ========================= -->
<section id="faq" class="py-20 lg:py-28 bg-white">
  <div class="container-tight">
    <div class="text-center">
      <span class="eyebrow">FAQ</span>
      <h2 class="h-section mt-3">Common questions. <span class="text-gradient-accent">Short answers.</span></h2>
    </div>

    <div class="mt-12 space-y-3" x-data="{ open: 0 }">
      <?php foreach ([
        ['Is LoanSathi free for borrowers?','Yes. We are paid a fee by the lender only when your loan is disbursed. You never pay us anything.'],
        ['What credit score do I need?','Most personal/home loans need 700+. We work with lenders who accept 650+ for select cases and gold/LAP options exist even for thinner profiles.'],
        ['How fast is disbursement?','Personal loans: 2–5 days. Gold loans: same day. Home loans: 7–14 days. The exact timeline depends on documentation completeness.'],
        ['Will I receive spam calls?','No. Your details are shared only with the 1–3 lenders matched to your profile, and only after you confirm by phone with our consultant.'],
        ['Can I get a loan without ITR?','Yes — gold loans, LAP, and many business loans accept alternative income proof. Tell the consultant your situation and they\'ll route appropriately.'],
      ] as $i => [$q,$a]): ?>
        <div class="bg-surface-100 rounded-2xl border border-ink/5 overflow-hidden">
          <button @click="open = open === <?= $i ?> ? -1 : <?= $i ?>"
                  class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-extrabold text-ink text-base sm:text-lg"><?= e($q) ?></span>
            <span :class="open === <?= $i ?> ? 'rotate-180 bg-brand-500 text-white' : 'bg-white text-ink-500'"
                  class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center border border-ink/5 transition-transform">
              <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M6 9l6 6 6-6"/></svg>
            </span>
          </button>
          <div x-show="open === <?= $i ?>" x-collapse x-cloak class="px-6 pb-5 text-ink-500 leading-relaxed"><?= $a ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ========================= LEAD CTA ========================= -->
<section class="py-20 lg:py-28 bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500 text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-grid bg-[length:48px_48px] opacity-15 pointer-events-none"></div>
  <div class="absolute -top-40 left-1/4 w-[36rem] h-[36rem] rounded-full bg-accent-500/30 blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-32 right-0 w-[28rem] h-[28rem] rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
  <div class="absolute top-12 right-12 w-32 h-32 text-white/15 dotted hidden lg:block"></div>

  <div class="container-page relative">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
      <div class="lg:col-span-7">
        <span class="chip-dark"><span class="w-1.5 h-1.5 rounded-full bg-success-400"></span> Step 1 of 1</span>
        <h2 class="mt-5 font-display text-4xl sm:text-5xl lg:text-[3.6rem] leading-[1.02] font-extrabold text-white">
          Drop your number.<br>
          <span class="text-accent-500">We'll do the running around.</span>
        </h2>
        <ul class="mt-8 space-y-3 text-white/90 text-base">
          <?php foreach ([
            'Free, no-obligation consultation',
            'Hand-picked offers from 20+ lenders',
            'Faster approvals with pre-screened profiles',
            'Available in English, हिंदी, ಕನ್ನಡ, தமிழ், తెలుగు',
          ] as $b): ?>
            <li class="flex items-start gap-3">
              <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-accent-500 shrink-0 mt-0.5">
                <svg viewBox="0 0 24 24" class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3.5"><path d="M5 13l4 4L19 7"/></svg>
              </span>
              <span><?= e($b) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <div class="mt-10 pt-8 border-t border-white/20 text-sm text-white/75">
          Prefer to chat? <a class="text-accent-500 font-extrabold hover:text-accent-400" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>" target="_blank" rel="noopener">WhatsApp us →</a>
          &nbsp;&middot;&nbsp; Call <a class="text-white font-extrabold" href="tel:<?= e(config('contact.phone')) ?>"><?= e(config('contact.phone_display')) ?></a>
        </div>
      </div>

      <div class="lg:col-span-5">
        <?php require __DIR__ . '/../partials/lead-form.php'; ?>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
