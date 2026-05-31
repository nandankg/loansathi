# LoanSathi — Google Ads Readiness via Education Funnel

**Date:** 2026-05-31
**Status:** Approved design (pending spec review)

## Context

LoanSathi is a PHP/MySQL loan-comparison + lead-generation site for the Indian
market. The owner wants to run Google Ads to acquire prospective small-loan
customers. Google Ads in India treats **personal loans** as a restricted
category: since June 2025, advertisers must pass **Financial Products &
Services verification**, proving they are an RBI-regulated entity (bank/NBFC)
or hold documented authorization from one. Lead generators and lender
connectors are explicitly inside this policy.

The business is currently an **unregistered referral/consultant** with no RBI
registration and no formal DSA agreements. Direct loan-lead ads would be
rejected.

## Decisions

1. **Brand name:** `LoanSathi` (existing, consistent). Reject "Dhani Finances
   Loan" — "Dhani" is a real RBI-registered NBFC (Dhani Services Ltd);
   reusing it risks trademark infringement and Google brand-impersonation
   disapproval.
2. **Ad strategy: pure education funnel.** Paid ads point ONLY to
   informational tool/guide pages (EMI calculator, eligibility, comparison,
   application guide). These ad landing pages do **not** solicit loan
   applications (no "Apply Now", no lead-capture form). The lead form remains
   on the organic homepage and is reached only through organic navigation —
   not directly from a paid click. This keeps paid traffic out of the
   personal-loans lead-gen policy.
3. **Real legal/compliance pages** replace the current `coming-soon` stubs.
4. **Placeholders:** Business details that are not yet confirmed are left as
   clearly-marked `FILL-IN: ____` slots.

## Scope — What gets built

### A. Legal / compliance pages (required regardless of ad strategy)
Each is a standalone PHP page following the existing
`$page_title`/`$page_description` + `header.php`/`footer.php` pattern, wired
into `routes_table()` in `src/lib/router.php` (replacing the `$stub`).

1. `/privacy-policy` — data collected (name, phone, loan need), purpose,
   sharing with partner lenders, consent, retention, user rights, DPDP Act
   2023 alignment, grievance contact.
2. `/terms-of-service` — "we facilitate, do not lend", no guarantee of
   approval, indicative rates, governing law (India), acceptable use.
3. `/disclaimer` — prominent: not a lender, not RBI-registered, referral
   model, rates indicative and subject to lender.
4. `/about` — business identity, model, physical address (`FILL-IN`).
5. `/contact` — physical address, phone, email (Google-required financial
   disclosure), grievance officer slot.

### B. Education landing pages for ads (no loan solicitation)
Standalone pages reusing the existing interactive tool markup/JS, but framed
as educational and WITHOUT "Apply for this loan" / lead-form CTAs. Soft CTA
allowed: "Learn more" / links to other guides.

1. `/emi-calculator` — standalone EMI tool + explainer content.
2. `/eligibility-checker` — standalone eligibility estimator + explainer.
3. `/loan-comparison` — comparison table + how-to-choose content.
4. `/application-guide` — content guide on documents & the loan process.

### C. Shared transparency disclosure partial
`src/partials/loan-disclosure.php` — reusable block stating representative
APR ranges, min/max repayment tenure, and a representative example with all
fees (matches Google's personal-loan disclosure format). Included on tool
pages and homepage for transparency, even though ad pages are educational.

### D. Fixes
1. `src/partials/header.php` — change logo text from
   "Instant PersonalLoan" to "LoanSathi" (matches rest of site).
2. `src/pages/home.php` — page title currently
   "InstantPersonalLoan — ..."; change to LoanSathi.
3. Contact placeholders (`+91XXXXXXXXXX`, email) remain `FILL-IN` until
   confirmed (these live in `.env` / `src/config/app.php`).

### E. The guide — `docs/google-ads-guide.md`
India-specific, step-by-step:
1. Eligibility reality + DSA registration path (for when they want true
   loan-lead ads later).
2. Pre-launch website compliance checklist.
3. Google Ads account + business/identity verification + Financial Services
   verification (5–15 business days).
4. Education-funnel campaign build: Search structure, informational keywords
   + match types, compliant ad copy, negative keywords, conversion tracking
   (tool engagement / soft conversions), bidding & budget.
5. Staying approved — disapproval triggers to avoid.
6. Measure & optimize — CPL/CPA, lead quality, A/B tests.

## Out of scope (YAGNI)
- Per-loan-type landing pages (`/personal-loan`, etc.) stay stubbed.
- Blog content.
- DSA registration itself (owner's offline action; documented in guide).
- No change to the lead submission backend.

## Testing / verification
- `composer test` (RouterTest) must still pass; add route assertions for the
  new live routes.
- Manual: each new route renders without PHP error and shows no "coming soon".
- Education landing pages contain no "Apply"/lead-form markup.
```
