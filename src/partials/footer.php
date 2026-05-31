<?php
$loan_types = config('loan_types');
$phone_ui   = config('contact.phone_display');
$email      = config('contact.email');
?>
</main>
<?php require __DIR__ . '/whatsapp-fab.php'; ?>
<?php require __DIR__ . '/cookie-banner.php'; ?>

<footer class="mt-0 bg-ink-900 text-white relative overflow-hidden">
  <div class="absolute -top-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-brand-500/20 blur-3xl pointer-events-none"></div>
  <div class="container-page relative py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 text-sm">
    <div class="lg:col-span-1">
      <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 text-white">
          <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5"><path d="M3 17l5-5 4 4 8-8" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/><circle cx="20" cy="8" r="2" fill="#ff6b35"/></svg>
        </span>
        <div class="font-display text-2xl font-extrabold leading-none">Loan<span class="text-accent-500">Sathi</span></div>
      </div>
      <p class="text-white/70 mt-4 leading-relaxed">Your trusted loan companion — comparing 20+ lenders so you don't have to.</p>
      <div class="mt-5 space-y-2 text-white/80">
        <a class="flex items-center gap-2 hover:text-accent-500 transition" href="tel:<?= e(config('contact.phone')) ?>">
          <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 5c0 9 7 16 16 16l2-4-4-2-2 2c-3-1-6-4-7-7l2-2-2-4-4-1Z"/></svg>
          <span class="nums font-semibold"><?= e($phone_ui) ?></span>
        </a>
        <a class="flex items-center gap-2 hover:text-accent-500 transition" href="mailto:<?= e($email) ?>">
          <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8l9 6 9-6 M3 8v10h18V8 M3 8l9-4 9 4"/></svg>
          <span class="font-semibold"><?= e($email) ?></span>
        </a>
      </div>
    </div>
    <div>
      <div class="text-white font-extrabold mb-4 uppercase tracking-wider text-xs">Loans</div>
      <ul class="space-y-2.5 text-white/70">
        <?php // Point to the live comparison page rather than the not-yet-built
              // per-loan-type pages, so no "coming soon" page is reachable from
              // an ad landing page footer. ?>
        <?php foreach ($loan_types as $slug => $label): ?>
          <li><a class="hover:text-white transition" href="/loan-comparison"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <div class="text-white font-extrabold mb-4 uppercase tracking-wider text-xs">Tools</div>
      <ul class="space-y-2.5 text-white/70">
        <li><a class="hover:text-white transition" href="/#tools">EMI Calculator</a></li>
        <li><a class="hover:text-white transition" href="/#tools">Eligibility Checker</a></li>
        <li><a class="hover:text-white transition" href="/#tools">Loan Comparison</a></li>
        <li><a class="hover:text-white transition" href="/application-guide">Application Guide</a></li>
      </ul>
    </div>
    <div>
      <div class="text-white font-extrabold mb-4 uppercase tracking-wider text-xs">Company</div>
      <ul class="space-y-2.5 text-white/70">
        <li><a class="hover:text-white transition" href="/about">About us</a></li>
        <li><a class="hover:text-white transition" href="/contact">Contact</a></li>
        <li><a class="hover:text-white transition" href="/blog">Blog</a></li>
        <li><a class="hover:text-white transition" href="/privacy-policy">Privacy Policy</a></li>
        <li><a class="hover:text-white transition" href="/terms-of-service">Terms</a></li>
        <li><a class="hover:text-white transition" href="/disclaimer">Disclaimer</a></li>
      </ul>
    </div>
  </div>
  <div class="border-t border-white/10 relative">
    <div class="container-page py-6 text-xs text-white/55 leading-relaxed">
      LoanSathi is an independent loan advisory service. We do not lend money. Loan terms (rate, fees, eligibility) are determined solely by the lender. Indicative rates shown across the site are for educational purposes and may change without notice.
      <div class="mt-3 text-white/40">© <?= date('Y') ?> LoanSathi. All rights reserved.</div>
    </div>
  </div>
</footer>
</body>
</html>
