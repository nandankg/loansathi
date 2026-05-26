<?php
$loan_types = config('loan_types');
$phone_ui   = config('contact.phone_display');
$email      = config('contact.email');
?>
</main>
<?php require __DIR__ . '/whatsapp-fab.php'; ?>
<?php require __DIR__ . '/cookie-banner.php'; ?>

<footer class="mt-16 bg-navy text-slate-200">
  <div class="container-page py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-sm">
    <div>
      <div class="text-white text-xl font-extrabold mb-3">Loan<span class="text-brand-amber">Sathi</span></div>
      <p class="text-slate-300/80 text-sm leading-relaxed">Your trusted loan companion — comparing lenders so you don't have to.</p>
      <p class="text-slate-400 text-xs mt-4">Call: <a class="text-white" href="tel:<?= e(config('contact.phone')) ?>"><?= e($phone_ui) ?></a></p>
      <p class="text-slate-400 text-xs">Email: <a class="text-white" href="mailto:<?= e($email) ?>"><?= e($email) ?></a></p>
    </div>
    <div>
      <div class="text-white font-bold mb-3">Loans</div>
      <ul class="space-y-2">
        <?php foreach ($loan_types as $slug => $label): ?>
          <li><a class="hover:text-white" href="/<?= e($slug === 'lap' ? 'loan-against-property' : $slug . '-loan') ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div>
      <div class="text-white font-bold mb-3">Tools</div>
      <ul class="space-y-2">
        <li><a class="hover:text-white" href="/emi-calculator">EMI Calculator</a></li>
        <li><a class="hover:text-white" href="/eligibility-checker">Eligibility Checker</a></li>
        <li><a class="hover:text-white" href="/loan-comparison">Loan Comparison</a></li>
        <li><a class="hover:text-white" href="/application-guide">Application Guide</a></li>
      </ul>
    </div>
    <div>
      <div class="text-white font-bold mb-3">Company</div>
      <ul class="space-y-2">
        <li><a class="hover:text-white" href="/about">About us</a></li>
        <li><a class="hover:text-white" href="/contact">Contact</a></li>
        <li><a class="hover:text-white" href="/blog">Blog</a></li>
        <li><a class="hover:text-white" href="/privacy-policy">Privacy Policy</a></li>
        <li><a class="hover:text-white" href="/terms-of-service">Terms</a></li>
        <li><a class="hover:text-white" href="/disclaimer">Disclaimer</a></li>
      </ul>
    </div>
  </div>
  <div class="border-t border-slate-700/60">
    <div class="container-page py-6 text-xs text-slate-400/80 leading-relaxed">
      LoanSathi is an independent loan advisory service. We do not lend money. Loan terms (rate, fees, eligibility) are determined solely by the lender. Indicative rates shown across the site are for educational purposes and may change without notice.
      <div class="mt-3">© <?= date('Y') ?> LoanSathi. All rights reserved.</div>
    </div>
  </div>
</footer>
</body>
</html>
