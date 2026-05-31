<?php
$page_title = 'Privacy Policy — LoanSathi';
$page_description = 'How LoanSathi collects, uses, shares, and protects your personal information, in line with India\'s Digital Personal Data Protection Act, 2023.';
$page_robots = 'index,follow';
require __DIR__ . '/../partials/header.php';

$email     = config('contact.email');
$phone     = config('contact.phone_display');
$entity    = config('legal.entity');
$address   = config('legal.address');
$grievance = config('legal.grievance_officer');
$updated   = 'May 31, 2026';
?>

<section class="bg-gradient-to-br from-brand-700 via-brand-600 to-brand-500 text-white relative overflow-hidden">
  <div class="absolute inset-0 bg-grid bg-[length:48px_48px] opacity-15 pointer-events-none"></div>
  <div class="container-page relative py-14 lg:py-20">
    <span class="chip-dark"><span class="w-1.5 h-1.5 rounded-full bg-success-400"></span> Legal</span>
    <h1 class="mt-5 font-display text-4xl sm:text-5xl font-extrabold">Privacy Policy</h1>
    <p class="mt-4 text-white/80 max-w-2xl">Last updated: <?= e($updated) ?></p>
  </div>
</section>

<article class="py-14 lg:py-20 bg-white">
  <div class="container-tight space-y-10 text-ink-700 leading-relaxed">

    <div class="card bg-surface-100 border-l-4 border-brand-500">
      <p class="text-sm">
        <strong class="text-ink">In short:</strong> LoanSathi is a loan-comparison
        and education service. We collect the minimum information needed to give
        you guidance or, if you ask, to introduce you to partner lenders. We never
        sell your data, and we share it with a lender only after you ask us to.
      </p>
    </div>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">1. Who we are</h2>
      <p class="mt-3">
        This website ("LoanSathi", "we", "us") is operated by
        <strong><?= e($entity) ?></strong>, having its
        registered office at <strong><?= e($address) ?></strong>.
        For any privacy question you can reach us at
        <a href="mailto:<?= e($email) ?>" class="text-brand-500 font-semibold"><?= e($email) ?></a>
        or <?= e($phone) ?>.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">2. Information we collect</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li><strong>Details you give us:</strong> name, mobile number, email, city, the loan type/amount you are interested in, and information you enter into our calculators (income, existing EMIs, age, credit-score range).</li>
        <li><strong>Information collected automatically:</strong> IP address, browser type, device, pages viewed, and similar analytics data via cookies and similar technologies.</li>
        <li>We do <strong>not</strong> ask for, store, or process sensitive financial documents (PAN, Aadhaar, bank statements) on this website. Any such documents are handled directly by the lender during their own application process.</li>
      </ul>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">3. How we use your information</h2>
      <ul class="mt-3 space-y-2 list-disc pl-5">
        <li>To respond to your enquiry and provide loan-comparison guidance.</li>
        <li>To introduce you to one or more partner lenders <em>when you request a callback or ask to be matched</em>.</li>
        <li>To improve our calculators, content, and website experience.</li>
        <li>To send service messages about your enquiry. We send marketing messages only with your consent, and you can opt out any time.</li>
      </ul>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">4. When we share your information</h2>
      <p class="mt-3">
        We share your contact details and stated loan requirement with partner
        banks and NBFCs <strong>only after you ask us to connect you</strong>
        (for example, by submitting the callback form or confirming on a call).
        We also use trusted service providers (hosting, email, analytics) who
        process data on our behalf under confidentiality obligations. We
        <strong>do not sell your personal data</strong> to anyone.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">5. Your rights (DPDP Act, 2023)</h2>
      <p class="mt-3">
        Under India's Digital Personal Data Protection Act, 2023, you may request
        access to, correction of, or deletion of your personal data, and you may
        withdraw consent at any time. To exercise these rights, email
        <a href="mailto:<?= e($email) ?>" class="text-brand-500 font-semibold"><?= e($email) ?></a>.
        We will respond within a reasonable period.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">6. Data retention &amp; security</h2>
      <p class="mt-3">
        We keep your data only as long as needed for the purpose it was collected
        or as required by law, then delete or anonymise it. We use reasonable
        technical and organisational safeguards (encryption in transit, access
        controls) to protect your information, though no method of transmission
        over the internet is 100% secure.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">7. Cookies</h2>
      <p class="mt-3">
        We use essential cookies to run the site and analytics/advertising
        cookies (including Google services) to understand traffic and measure
        campaigns. You can control cookies through your browser settings.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">8. Grievance officer</h2>
      <p class="mt-3">
        Grievance Officer: <strong><?= e($grievance) ?></strong> ·
        <a href="mailto:<?= e($email) ?>" class="text-brand-500 font-semibold"><?= e($email) ?></a> ·
        <?= e($phone) ?>. We aim to acknowledge complaints within 48 hours.
      </p>
    </section>

    <section>
      <h2 class="font-display text-2xl font-extrabold text-ink">9. Changes to this policy</h2>
      <p class="mt-3">
        We may update this policy from time to time. The "last updated" date at
        the top reflects the latest revision. Continued use of the site means you
        accept the current version.
      </p>
    </section>

    <div class="pt-6 border-t border-ink/10 text-sm text-ink-500">
      See also our <a href="/terms-of-service" class="text-brand-500 font-semibold">Terms of Service</a>
      and <a href="/disclaimer" class="text-brand-500 font-semibold">Disclaimer</a>.
    </div>
  </div>
</article>

<?php require __DIR__ . '/../partials/footer.php'; ?>
