<?php
$page_title = 'Terms of Service — LoanSathi';
$page_description = 'The terms governing your use of LoanSathi, an independent loan-comparison and education service. We facilitate introductions to lenders; we do not lend.';
$page_robots = 'index,follow';
require __DIR__ . '/../partials/header.php';

$email        = config('contact.email');
$jurisdiction = config('legal.jurisdiction');
$updated      = 'May 31, 2026';
?>

<section class="bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500 text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-grid bg-[length:48px_48px] opacity-15 pointer-events-none"></div>
  <div class="container-page relative py-14 lg:py-20">
    <span class="chip-dark"><span class="w-1.5 h-1.5 rounded-full bg-success-400"></span> Legal</span>
    <h1 class="mt-5 font-display text-4xl sm:text-5xl font-extrabold">Terms of Service</h1>
    <p class="mt-4 text-white/80 max-w-2xl">Last updated: <?= e($updated) ?></p>
  </div>
</section>

<article class="py-14 lg:py-20 bg-white">
  <div class="container-tight space-y-10 text-ink-700 leading-relaxed">

    <p>
      These Terms of Service ("Terms") govern your use of the LoanSathi website
      and services. By using this site you agree to these Terms. If you do not
      agree, please do not use the site.
    </p>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">1. What LoanSathi is — and is not</h2>
      <p class="mt-3">
        LoanSathi is an <strong>independent loan-comparison and education
        service</strong>. We provide information, calculators, and — only when
        you ask — introductions to third-party banks and NBFCs ("partner
        lenders"). <strong>We are not a bank, NBFC, or lender. We do not lend
        money, do not accept deposits, and do not guarantee that any loan will be
        approved.</strong> All credit decisions, interest rates, fees, and terms
        are made solely by the lender.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">2. No fees from borrowers</h2>
      <p class="mt-3">
        Our comparison and introduction services are free for you. Where we are
        compensated, it is by the partner lender, typically only if your loan is
        disbursed. This does not change the price you pay the lender.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">3. Information is indicative</h2>
      <p class="mt-3">
        Interest rates, EMIs, eligibility amounts, fees, and approval timelines
        shown on this site are <strong>indicative and for educational purposes
        only</strong>. They are not an offer of credit and may change without
        notice. Calculator results are estimates; your real figures come from the
        lender's sanction letter and Key Fact Statement.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">4. Your responsibilities</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li>Provide accurate, current information.</li>
        <li>Use the site only for lawful purposes and only for yourself or with authority to act for another.</li>
        <li>Do not attempt to disrupt, scrape, or gain unauthorised access to the site.</li>
        <li>Read every lender document carefully and borrow only what you can repay.</li>
      </ul>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">5. Third-party lenders &amp; links</h2>
      <p class="mt-3">
        When you choose to be introduced to a partner lender, your relationship
        for the loan is directly with that lender and governed by their terms. We
        are not responsible for the products, decisions, or conduct of any lender
        or third-party website linked from here.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">6. Limitation of liability</h2>
      <p class="mt-3">
        To the maximum extent permitted by law, LoanSathi is not liable for any
        loss arising from your use of the site, reliance on indicative
        information, or any loan you take with a lender. The site is provided "as
        is" without warranties of any kind.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">7. Intellectual property</h2>
      <p class="mt-3">
        All content, branding, and design on this site are owned by LoanSathi or
        its licensors and may not be copied or reused without permission.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">8. Governing law</h2>
      <p class="mt-3">
        These Terms are governed by the laws of India, and the courts at
        <strong><?= e($jurisdiction) ?></strong> shall have exclusive jurisdiction.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">9. Contact</h2>
      <p class="mt-3">
        Questions about these Terms? Email
        <a href="mailto:<?= e($email) ?>" class="text-brand-500 font-semibold"><?= e($email) ?></a>.
      </p>
    </section>

    <div class="pt-6 border-t border-ink/10 text-sm text-ink-500">
      See also our <a href="/privacy-policy" class="text-brand-500 font-semibold">Privacy Policy</a>
      and <a href="/disclaimer" class="text-brand-500 font-semibold">Disclaimer</a>.
    </div>
  </div>
</article>

<?php require __DIR__ . '/../partials/footer.php'; ?>
