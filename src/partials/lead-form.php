<?php
require_once __DIR__ . '/../lib/csrf.php';
$loan_types = config('loan_types');
$defaultType = $lead_form_default_type ?? '';
$source      = $lead_form_source      ?? 'lead-form';
$title       = $lead_form_title       ?? 'Get a free callback in 24 hours';
?>
<div id="lead-form" class="bg-white rounded-2xl shadow-card p-6 sm:p-8"
     x-data="leadForm({source: '<?= e($source) ?>'})"
     x-init="init()">
  <h3 class="text-xl font-extrabold text-navy mb-1"><?= e($title) ?></h3>
  <p class="text-sm text-slate-500 mb-4">No fees from you — we get paid by the lender once your loan is disbursed.</p>

  <template x-if="status === 'success'">
    <div class="rounded-lg bg-green-50 border border-green-200 text-green-800 p-4 text-sm">
      <strong>Thanks!</strong> We'll be in touch within 24 hours. Or chat with us on
      <a class="underline font-semibold" target="_blank" href="https://wa.me/<?= e(config('contact.whatsapp')) ?>">WhatsApp</a> for an instant reply.
    </div>
  </template>

  <form x-show="status !== 'success'" @submit.prevent="submit" class="space-y-3" novalidate>
    <?= csrf_field() ?>
    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

    <div>
      <input class="input-field" :class="{'error': errors.name}" type="text" name="name" placeholder="Your full name" x-model="form.name" required>
      <p class="error-text" x-text="errors.name" x-show="errors.name"></p>
    </div>
    <div>
      <input class="input-field" :class="{'error': errors.phone}" type="tel" inputmode="tel" name="phone" placeholder="Mobile number (10-digit)" x-model="form.phone" required>
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
    <div>
      <input class="input-field" type="number" name="loan_amount" placeholder="Loan amount (₹, optional)" x-model="form.loan_amount" min="0">
    </div>
    <div>
      <input class="input-field" type="text" name="city" placeholder="Your city (optional)" x-model="form.city">
    </div>

    <button type="submit" class="btn-primary w-full" :disabled="status==='submitting'">
      <span x-show="status!=='submitting'">Request callback</span>
      <span x-show="status==='submitting'">Submitting...</span>
    </button>

    <template x-if="status === 'error'">
      <p class="text-sm text-red-600">Something went wrong. Please try again or call us at <?= e(config('contact.phone_display')) ?>.</p>
    </template>

    <p class="text-xs text-slate-500 text-center">By submitting, you agree to our <a class="underline" href="/privacy-policy">Privacy Policy</a>.</p>
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
