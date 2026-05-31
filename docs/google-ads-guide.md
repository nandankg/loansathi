# LoanSathi — Google Ads Approval & Effective-Campaign Guide

**Last updated:** 2026-05-31
**Market:** India · **Strategy:** Education funnel (low-risk) → leads on-site

> **Read this first.** Google treats *personal loans* as a restricted category.
> In India (since June 2025) anyone advertising personal loans must pass
> **Financial Products & Services verification**, proving they are an
> RBI-regulated lender (bank/NBFC) or hold documented authorization from one.
> **Lead generators and lender-connectors are explicitly inside this policy.**
> LoanSathi is currently an unregistered referral business, so *direct
> loan-lead ads will be rejected.*
>
> This guide therefore uses a **two-track plan**:
> - **Track A (start now):** advertise the *education funnel* — calculators
>   and guides — which does not solicit loan applications and stays out of the
>   personal-loans policy.
> - **Track B (unlock loan-lead ads):** register as a DSA / get lender
>   authorization, then complete Google's financial-services verification.

---

## Table of contents
1. [The eligibility reality & how to fix it (Track B)](#1-eligibility)
2. [Pre-launch website compliance checklist](#2-website-checklist)
3. [Google Ads account & verification setup](#3-account-setup)
4. [Track A — the education-funnel campaign (build step by step)](#4-campaign)
5. [Writing ads that get approved](#5-ad-copy)
6. [Conversion tracking & measurement](#6-tracking)
7. [Staying approved — disapproval triggers to avoid](#7-staying-approved)
8. [Optimization playbook](#8-optimization)
9. [30-day launch checklist](#9-launch-checklist)

---

<a name="1-eligibility"></a>
## 1. The eligibility reality & how to fix it (Track B)

**Why ads get rejected for loans in India**
- Google requires **Financial Products & Services verification** for loan ads.
- You must show you are RBI-regulated **or** authorized by a regulated lender.
- "We're just a consultant / comparison site" does **not** exempt you if your
  ads/landing pages generate loan leads.

**How to become eligible (do this in parallel with Track A):**

1. **Register as a DSA (Direct Selling Agent).** Banks and NBFCs actively
   recruit DSAs. You can register:
   - **Directly** with lenders (HDFC, ICICI, Axis, Bajaj Finserv, Tata
     Capital, Kotak, etc.) via their DSA / channel-partner programs, **or**
   - **Through an aggregator/DSA network** (e.g., Andromeda, Ruloans,
     BankSathi, Paisabazaar partner program) — faster onboarding, one
     relationship, many lenders.
   - You'll typically need: business registration (proprietorship/LLP/Pvt
     Ltd), PAN, GST (if applicable), bank account, and a signed DSA agreement.
     You receive a **DSA code** and an authorization letter.
2. **Keep the authorization documents.** Google's verification accepts
   documentation showing you're authorized to promote a regulated entity's
   products. Your DSA agreement / authorization letter is what you submit.
3. **Complete Google's financial-services verification** (see §3). Allow
   **5–15 business days**. Do this *before* you intend to run loan-lead ads.

Until Track B is done, **run only Track A**.

---

<a name="2-website-checklist"></a>
## 2. Pre-launch website compliance checklist

Google reviews the landing page *and* the whole site. The following are now
built into LoanSathi (✔), or still need your input (⬜ FILL-IN):

**Legal & identity (built ✔ — fill the placeholders)**
- [x] Privacy Policy (`/privacy-policy`) — DPDP-aligned, data sharing explained
- [x] Terms of Service (`/terms-of-service`)
- [x] Disclaimer (`/disclaimer`) — "not a lender, not RBI-registered, indicative rates"
- [x] About page (`/about`) — clear business identity & model
- [x] Contact page (`/contact`) — phone, email, registered address
- [x] Footer disclosure on every page
- [x] Cost-transparency block (APR range, tenure, representative example)
- [ ] **`.env`:** `LEGAL_ENTITY` — registered legal entity name
- [ ] **`.env`:** `LEGAL_ADDRESS` — full registered office address
- [ ] **`.env`:** `LEGAL_GRIEVANCE_OFFICER` — grievance officer name
- [ ] **`.env`:** `LEGAL_JURISDICTION` — governing-law city/state (Terms)
- [ ] **`.env`:** real phone / WhatsApp / email (`CONTACT_*`, replace `+91XXXXXXXXXX`)

  > All legal/identity text now comes from `.env` (see `.env.example`). Set
  > these once on the server — no PHP editing needed. Values with spaces must
  > be wrapped in double quotes.

**Technical / trust signals**
- [ ] Site served over **HTTPS** with a valid SSL certificate (required).
- [ ] Domain matches the business name and is not brand-new the day you launch.
- [ ] No broken links, no "coming soon" pages reachable from ads.
- [ ] Mobile-fast and responsive (most Indian traffic is mobile).
- [ ] Functional cookie consent banner (already present).

**Ad-landing-page rule for Track A**
- [ ] Ad landing pages = **`/emi-calculator`, `/eligibility-checker`,
      `/loan-comparison`, `/application-guide`** only.
- [ ] These pages have **no "Apply Now" / no lead-capture form** (verified —
      they link to other educational pages instead).
- [ ] The lead form lives only on the homepage, reached by organic navigation.

---

<a name="3-account-setup"></a>
## 3. Google Ads account & verification setup

1. **Create the Google Ads account** with a business email on your domain.
2. **Advertiser identity verification** (Google now requires this for most
   accounts): submit business registration + a representative's ID. Takes a
   few days.
3. **Business verification** — verify domain ownership and business details.
4. **Financial products & services verification** (needed for Track B / loan
   ads): in *Account → Summary / Policy manager* you'll be prompted; submit
   your DSA authorization or RBI documentation. **5–15 business days.**
5. **Set the billing country to India**, currency INR, and confirm time zone
   (IST).
6. **Link Google Analytics 4 (GA4)** and **Google Search Console**.

> For **Track A** you can begin once identity + business verification are
> done; full financial-services verification is only required when you run
> loan-product ads (Track B).

---

<a name="4-campaign"></a>
## 4. Track A — the education-funnel campaign (build step by step)

**Goal:** drive cheap, policy-safe traffic to your calculators/guides, capture
engagement + soft conversions, and let interested users navigate to the
homepage lead form organically.

### 4.1 Campaign settings
- **Type:** Search (start here; it's intent-driven and easiest to keep compliant).
- **Networks:** Search only. **Turn OFF** "Search partners" and "Display
  Network" at launch (cheaper, cleaner data).
- **Locations:** Target specific cities/states you can service. Set location
  option to **"Presence: people in your targeted locations"** (not "interest").
- **Language:** English + Hindi (and regional languages you support).
- **Bidding:** Start **Manual CPC** or **Maximize Clicks with a max-CPC cap**
  for the first ~2 weeks to gather data, then switch to **Maximize
  Conversions / Target CPA** once you have ~15–30 conversions.
- **Budget:** Start small — e.g., **₹500–₹1,000/day** per campaign — and scale
  what works.

### 4.2 Ad-group structure (one tightly-themed ad group per tool)
| Ad group | Theme | Final URL |
|---|---|---|
| EMI Calculator | "how much will my EMI be" | `/emi-calculator` |
| Eligibility | "how much loan can I get" | `/eligibility-checker` |
| Compare loans | "compare loan types/rates" | `/loan-comparison` |
| How to apply | "documents / process" | `/application-guide` |

### 4.3 Keywords (informational intent — keeps you policy-safe)
Use **phrase** and **exact** match; avoid broad match at launch.

- EMI Calculator: `"emi calculator"`, `[personal loan emi calculator]`,
  `"home loan emi calculator"`, `"loan emi calculation"`
- Eligibility: `"loan eligibility calculator"`,
  `[how much loan can i get on my salary]`, `"home loan eligibility"`
- Compare: `"compare personal loan interest rates"`, `"types of loans in india"`,
  `"secured vs unsecured loan"`
- Guide: `"documents required for personal loan"`, `"how to apply for a loan"`,
  `"loan application process"`

### 4.4 Negative keywords (add at campaign level)
Prevent wasted spend and risky queries:
`free loan`, `instant loan no documents`, `loan without cibil`,
`guaranteed approval`, `loan app`, `1000 rupee loan`, `aadhar card loan`,
`job`, `jobs`, `calculator app download`, `excel`, plus competitor brand names
and any "scammy" phrasing. Review the **Search terms report** weekly and keep
adding negatives.

### 4.5 Ad extensions (assets) — add all that apply
- **Sitelinks:** EMI Calculator, Eligibility, Compare Loans, Application Guide.
- **Callouts:** "Free tools", "No sign-up", "Compare 20+ lenders",
  "Educational guidance".
- **Structured snippets:** Loan types (Personal, Home, Business, Gold…).
- **Do NOT** use a call extension for Track A (calls imply lead-gen for loans).

---

<a name="5-ad-copy"></a>
## 5. Writing ads that get approved

**The golden rule for Track A:** advertise the *tool/information*, never the
*loan offer*. Match the ad to the educational landing page.

**Do**
- "Free EMI Calculator — Estimate Your Monthly Payment"
- "Check Your Loan Eligibility — No Sign-Up"
- "Compare Loan Types, Rates & Tenures in India"
- "Loan Documents Checklist & Application Guide"
- Include "educational", "compare", "calculate", "guide".

**Don't (these trigger the personal-loans policy or disapprovals)**
- ❌ "Get a Personal Loan in 10 Minutes"
- ❌ "Instant Cash / Guaranteed Approval / No Credit Check"
- ❌ Any specific APR/amount promise you can't substantiate
- ❌ Misleading urgency or "apply now for a loan"

**Responsive Search Ad recipe (per ad group):**
- 15 headlines (mix the keyword, the benefit, and the "free/no-signup" angle),
  pin one headline that names the tool (e.g., "EMI Calculator").
- 4 descriptions emphasising "free", "educational", "compare", "no obligation".
- Add a clear, non-promissory note where natural ("Indicative figures only").

**Display path:** use `loansathi.in/emi-calculator` style paths.

---

<a name="6-tracking"></a>
## 6. Conversion tracking & measurement

Because Track A doesn't capture loan leads on the ad page, track **engagement
and soft conversions** instead:

1. **GA4 events → import as conversions** in Google Ads:
   - `calculate_emi` (click of "Calculate EMI")
   - `check_eligibility` (click of "Check Eligibility")
   - `tool_engaged` (e.g., 30s on page + interaction)
   - `nav_to_homepage_form` (click from a tool page to `/#lead-form`)
2. **Primary on-site conversion (organic + assisted):** the homepage lead-form
   submission → `/thank-you`. Mark `/thank-you` pageview as a conversion.
3. **Call conversions** (only relevant for Track B): track calls to your
   number once you're verified for loan ads.
4. Use **GA4 funnels** to see how many tool visitors reach the lead form and
   convert — that's your true ROI for Track A.

**KPIs to watch:** CTR, CPC, cost per tool-engagement, tool→form rate,
cost per lead (CPL), and lead→disbursal rate (from your CRM/`leads` table).

---

<a name="7-staying-approved"></a>
## 7. Staying approved — disapproval triggers to avoid

- **Brand impersonation:** never use another lender's brand (e.g., "Dhani",
  "Bajaj") as *your* name or in a misleading way. This causes suspension.
- **Mismatch:** ad promises something the landing page doesn't deliver.
- **Missing disclosures:** if you ever run loan-product ads, the landing page
  must show max APR, min/max tenure, and a representative example (already
  built into the disclosure block).
- **Restricted claims:** "guaranteed", "instant approval", "no credit check".
- **Broken/under-construction landing pages** reachable from ads.
- **Collecting sensitive data insecurely** (no document collection on-site).
- If disapproved: read the exact policy cited in *Policy manager*, fix, and
  **request review** — don't just resubmit unchanged.

---

<a name="8-optimization"></a>
## 8. Optimization playbook

**Week 1–2 (learn):** manual CPC, tight keywords, daily search-terms review,
pile up negatives, ensure tracking fires.

**Week 3–4 (tune):** pause keywords with high spend & zero conversions; raise
bids on converting keywords; test 2–3 RSA variations per ad group; switch to
**Maximize Conversions** once you have ~15–30 conversions.

**Month 2+ (scale):**
- Add converting search terms as exact-match keywords.
- Expand to new cities that mirror your best performers.
- Build a **remarketing** audience of tool users → show them educational
  follow-ups (Display/YouTube), staying non-promissory.
- A/B test landing-page headlines and the tool→form path.
- Improve **Quality Score** (relevance + landing-page experience + CTR) to cut
  CPC.

**Lead quality loop:** tie `leads` outcomes back to keywords/ad groups; spend
more where leads actually convert to disbursals, not just where CPL is lowest.

---

<a name="9-launch-checklist"></a>
## 9. 30-day launch checklist

**Before launch**
- [ ] Fill every `FILL-IN` placeholder on the site (entity, address, phone, etc.)
- [ ] Site on HTTPS; all legal pages live; no "coming soon" reachable from ads
- [ ] GA4 + Search Console linked; conversion events created & tested
- [ ] Google Ads identity + business verification complete
- [ ] (Track B) DSA registration done & financial-services verification submitted

**Launch (Track A)**
- [ ] 4 ad groups, phrase/exact keywords, negatives loaded
- [ ] RSAs written to the "advertise the tool, not the loan" rule
- [ ] Sitelink/callout/snippet assets added
- [ ] Search-only, partners & display OFF, locations set to "presence"
- [ ] ₹500–₹1,000/day budget, manual CPC cap

**First 30 days**
- [ ] Daily: scan search terms, add negatives
- [ ] Weekly: pause waste, shift budget to winners, check CPL & tool→form rate
- [ ] Day ~21: switch to automated bidding once conversions allow
- [ ] When Track B verification clears: launch a *separate*, fully-compliant
      loan-product campaign with the required on-page disclosures

---

### Quick reference — what changed on the site for this
- New legal pages: `/privacy-policy`, `/terms-of-service`, `/disclaimer`,
  `/about`, `/contact`
- New education landing pages (ad destinations, no loan solicitation):
  `/emi-calculator`, `/eligibility-checker`, `/loan-comparison`,
  `/application-guide`
- New reusable cost-disclosure block: `src/partials/loan-disclosure.php`
- Branding unified to **LoanSathi** (header + homepage title)
- Routes wired in `src/lib/router.php`

> This guide is operational marketing guidance, not legal advice. Confirm your
> regulatory obligations (RBI digital-lending rules, DSA terms, DPDP Act) with
> a qualified professional before running loan-product ads.
