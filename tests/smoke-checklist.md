# Smoke Checklist — Plan 1 Foundation

Run after every deployment / major change.

## Build

- [ ] `composer install`
- [ ] `npm install && npm run build` (re-run any time PHP templates are added/changed — Tailwind only emits classes it scans)
- [ ] `php bin/install.php` (idempotent)

## Pages

- [ ] `GET /` → 200, homepage renders, no console errors
- [ ] `GET /no-such-page` → 404, branded page
- [ ] `GET /thank-you` → 200, `<meta name="robots" content="noindex,nofollow">` present
- [ ] `GET /submit-lead` → 405

## Lead pipeline

- [ ] Submit a valid lead from the form → inline thank-you appears
- [ ] DB row inserted in `leads` table
- [ ] Email arrives at the configured lead inbox (if SMTP is configured)
- [ ] Submit lead with empty name → inline validation error visible
- [ ] Submit lead 6+ times from same IP within an hour → 429 response on the 6th

## Cross-cutting

- [ ] WhatsApp FAB visible on every page
- [ ] Cookie banner appears once; dismisses on "Got it"; stays dismissed after refresh
- [ ] Click-to-call number visible on mobile and desktop nav
- [ ] No PHP warnings in `storage/logs/`

## Tests

- [ ] `composer test` → all green
