<?php
$page_title = 'About LoanSathi — Independent Loan Comparison & Guidance';
$page_description = 'LoanSathi is an independent loan-comparison and education service for Indian borrowers. Learn who we are, how we make money, and why we are free for you.';
$page_robots = 'index,follow';
require __DIR__ . '/../partials/header.php';

$phone   = config('contact.phone_display');
$email   = config('contact.email');
?>

<section class="bg-gradient-to-br from-surface-100 via-white to-surface-100 relative overflow-hidden">
  <div class="absolute -top-32 -right-20 w-[36rem] h-[36rem] rounded-full bg-glow-blue pointer-events-none"></div>
  <div class="container-page relative py-14 lg:py-20">
    <span class="eyebrow">About us</span>
    <h1 class="mt-4 font-display text-4xl sm:text-5xl font-extrabold text-ink max-w-3xl">
      We help Indians <span class="text-brand-500">compare loans</span> and borrow smarter.
    </h1>
    <p class="mt-5 text-lg text-ink-500 max-w-2xl leading-relaxed">
      LoanSathi is an independent loan-comparison and financial-education
      platform. We are not a lender — we put clear information and honest
      comparison in your hands, and connect you to the right partner lender only
      when you ask.
    </p>
  </div>
</section>

<section class="py-14 lg:py-20 bg-white">
  <div class="container-page grid grid-cols-1 lg:grid-cols-3 gap-10">
    <div class="lg:col-span-2 space-y-8 text-ink-700 leading-relaxed">
      <div>
        <h2 class="font-display text-2xl font-extrabold text-ink">What we do</h2>
        <p class="mt-3">
          We make borrowing less confusing. Our free calculators help you
          estimate EMIs and eligibility, our comparison tables show indicative
          rates across loan types, and our guides explain the documents and steps
          involved. If you want a human, a consultant can walk you through your
          options and — with your consent — introduce you to partner banks and
          NBFCs that fit your profile.
        </p>
      </div>

      <div>
        <h2 class="font-display text-2xl font-extrabold text-ink">How we make money</h2>
        <p class="mt-3">
          We are <strong>free for borrowers</strong>. When you take a loan through
          a partner lender we introduced, the lender may pay us a referral or
          facilitation fee, typically only on disbursal. This never increases the
          cost you pay the lender, and we are transparent about it so you always
          know where we stand.
        </p>
      </div>

      <div>
        <h2 class="font-display text-2xl font-extrabold text-ink">What we are not</h2>
        <p class="mt-3">
          We are not a bank, NBFC, or RBI-registered lender. We do not lend money
          or make credit decisions. All loan terms — rate, fees, eligibility,
          approval — are decided solely by the lender. See our
          <a href="/disclaimer" class="text-brand-500 font-semibold">disclaimer</a>
          for the full picture.
        </p>
      </div>
    </div>

    <aside class="card h-fit">
      <h2 class="font-display text-xl font-extrabold text-ink">Business details</h2>
      <dl class="mt-4 space-y-3 text-sm">
        <div>
          <dt class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Operated by</dt>
          <dd class="mt-0.5 text-ink-700"><strong>FILL-IN: Registered Legal Entity Name</strong></dd>
        </div>
        <div>
          <dt class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Registered address</dt>
          <dd class="mt-0.5 text-ink-700">FILL-IN: Full Registered Address, City, State, PIN</dd>
        </div>
        <div>
          <dt class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Phone</dt>
          <dd class="mt-0.5 text-ink-700 nums"><a href="tel:<?= e(config('contact.phone')) ?>" class="hover:text-brand-500"><?= e($phone) ?></a></dd>
        </div>
        <div>
          <dt class="text-[11px] uppercase tracking-wider font-extrabold text-ink-500">Email</dt>
          <dd class="mt-0.5 text-ink-700"><a href="mailto:<?= e($email) ?>" class="hover:text-brand-500"><?= e($email) ?></a></dd>
        </div>
      </dl>
      <a href="/contact" class="btn-primary w-full mt-6 !text-sm">Contact us</a>
    </aside>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
