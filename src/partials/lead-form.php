<?php
require_once __DIR__ . '/../lib/csrf.php';
$loan_types = config('loan_types');
$defaultType = $lead_form_default_type ?? '';
$source      = $lead_form_source      ?? 'lead-form';
$title       = $lead_form_title       ?? 'Get a free callback';
?>
<div id="lead-form" class="bg-white rounded-3xl shadow-deep p-6 sm:p-8 relative"
     x-data="leadForm({source: '<?= e($source) ?>'})"
     x-init="init()">
  <div class="absolute -top-3 -right-3 bg-accent-500 text-white text-[11px] font-extrabold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-card">
    24-hr callback
  </div>
  <h3 class="font-display text-2xl font-extrabold text-ink"><?= e($title) ?></h3>
  <p class="text-sm text-ink-500 mt-1.5">No fees from you — we're paid by the lender on disbursement.</p>

  <template x-if="status === 'success'">
    <div class="mt-5 rounded-2xl bg-success-50 border border-success-500/30 text-success-600 p-5 text-sm">
      <div class="font-extrabold text-base text-ink">Thanks! We've got it.</div>
      <p class="mt-1 text-ink-700">A consultant will call within 24 hours. Need it faster?
        <a class="underline font-extrabold text-success-600" target="_blank" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>">WhatsApp us →</a>
      </p>
    </div>
  </template>

  <form x-show="status !== 'success'" @submit.prevent="submit" class="mt-5 space-y-3" novalidate>
    <?= csrf_field() ?>
    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

    <div>
      <input class="input-field" :class="{'error': errors.name}" type="text" name="name" placeholder="Your full name" x-model="form.name" required>
      <p class="error-text" x-text="errors.name" x-show="errors.name"></p>
    </div>
    <div>
      <input class="input-field nums" :class="{'error': errors.phone}" type="tel" inputmode="tel" name="phone" placeholder="Mobile (10-digit)" x-model="form.phone" required>
      <p class="error-text" x-text="errors.phone" x-show="errors.phone"></p>
    </div>
    <div>
      <input class="input-field" :class="{'error': errors.email}" type="email" name="email" placeholder="Email (optional)" x-model="form.email">
      <p class="error-text" x-text="errors.email" x-show="errors.email"></p>
    </div>
    <div>
      <select class="input-field" :class="{'error': errors.loan_type}" name="loan_type" x-model="form.loan_type" required>
        <option value="">Select loan type</option>
        <?php foreach ($loan_types as $slug => $label): ?>
          <option value="<?= e($slug) ?>" <?= $defaultType === $slug ? 'selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>
      <p class="error-text" x-text="errors.loan_type" x-show="errors.loan_type"></p>
    </div>
    <div class="grid grid-cols-2 gap-3">
      <div class="relative">
        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-ink-400 font-bold pointer-events-none">₹</span>
        <input class="input-field pl-8 nums" type="number" name="loan_amount" placeholder="Amount" x-model="form.loan_amount" min="0">
      </div>
      <input class="input-field" type="text" name="city" placeholder="Your city" x-model="form.city">
    </div>

    <button type="submit" class="btn-accent w-full !justify-center" :disabled="status==='submitting'">
      <span x-show="status!=='submitting'">Request callback</span>
      <span x-show="status==='submitting'">Submitting...</span>
      <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" x-show="status!=='submitting'"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </button>

    <template x-if="status === 'error'">
      <p class="text-sm text-red-600 text-center">Something went wrong. Please try again or call <?= e(config('contact.phone_display')) ?>.</p>
    </template>

    <p class="text-[11px] text-ink-500 text-center pt-1">By submitting, you agree to our <a class="underline hover:text-brand-500" href="/privacy-policy">Privacy Policy</a>.</p>
  </form>
</div>

<script>
function leadForm(opts){
  return {
    status: 'idle',
    form: { name:'', phone:'', email:'', loan_type:'<?= e($defaultType) ?>', loan_amount:'', city:'', source_form: opts.source },
    errors: {},
    init() {},
    async submit() {
      this.status = 'submitting';
      this.errors = {};
      try {
        const res = await fetch('/submit-lead', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ ...this.form, _csrf: document.querySelector('#lead-form input[name=_csrf]').value, website: document.querySelector('#lead-form input[name=website]').value, source_page: location.pathname }),
        });
        const data = await res.json();
        if (res.ok && data.ok) {
          this.status = 'success';
          if (window.dataLayer) window.dataLayer.push({event:'lead_submit', loan_type:this.form.loan_type});
          if (window.gaEvent) window.gaEvent('generate_lead', {loan_type:this.form.loan_type});
        } else {
          this.errors = data.errors || {};
          this.status = res.status === 429 ? 'error' : 'idle';
          if (res.status === 429) this.errors._all = 'Too many submissions. Please try later.';
        }
      } catch (e) {
        this.status = 'error';
      }
    }
  };
}
</script>
