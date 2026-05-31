<?php
/**
 * GA4 analytics + conversion tracking, gated on cookie consent.
 *
 * The gtag.js library is injected only after the visitor accepts the cookie
 * banner (localStorage 'cookie_ok'), or immediately on later visits once they
 * already accepted. Events fired before consent are queued and flushed on load.
 *
 * Emits these events (import the ones you want as conversions in Google Ads):
 *   - calculate_emi        click of the "Calculate EMI" button
 *   - check_eligibility    click of the "Check Eligibility" button
 *   - tool_engaged         first interaction with a calculator on the page
 *   - nav_to_lead_form     click of any link to the homepage lead form
 *   - generate_lead        fired by the lead form on a successful submit
 *
 * A page may also fire a one-off event on load by setting $page_ga_event
 * (and optional $page_ga_event_params) before including the header.
 *
 * Requires GA4_MEASUREMENT_ID in .env. Renders nothing when unset.
 */
$ga4 = config('ga4_id');
if (!$ga4) return;
?>
<script>
(function () {
  var GA_ID = <?= json_encode($ga4) ?>;
  window.dataLayer = window.dataLayer || [];
  function gtag() { dataLayer.push(arguments); }
  window.gtag = gtag;

  var loaded = false;
  window.__gaQueue = window.__gaQueue || [];

  window.__loadGA4 = function () {
    if (loaded) return;
    loaded = true;
    var s = document.createElement('script');
    s.async = true;
    s.src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_ID;
    document.head.appendChild(s);
    gtag('js', new Date());
    gtag('config', GA_ID);
    window.__gaQueue.forEach(function (e) { gtag('event', e.name, e.params); });
    window.__gaQueue = [];
  };

  // Send an event now if GA is loaded, otherwise queue until consent is given.
  window.gaEvent = function (name, params) {
    params = params || {};
    if (loaded) { gtag('event', name, params); }
    else { window.__gaQueue.push({ name: name, params: params }); }
  };

  // Auto-load on visits where the banner was already accepted.
  try { if (localStorage.getItem('cookie_ok')) window.__loadGA4(); } catch (e) {}

  // Per-page conversion event (e.g. generate_lead on the thank-you page).
<?php if (!empty($page_ga_event)): ?>
  window.gaEvent(<?= json_encode($page_ga_event) ?>, <?= json_encode($page_ga_event_params ?? []) ?>);
<?php endif; ?>

  // Engagement / soft-conversion wiring.
  document.addEventListener('DOMContentLoaded', function () {
    var emiBtn = document.querySelector('[data-emi-calculate]');
    if (emiBtn) emiBtn.addEventListener('click', function () {
      window.gaEvent('calculate_emi', { tool: 'emi_calculator' });
    });

    var eligBtn = document.querySelector('[data-elig-calculate]');
    if (eligBtn) eligBtn.addEventListener('click', function () {
      window.gaEvent('check_eligibility', { tool: 'eligibility_checker' });
    });

    Array.prototype.forEach.call(
      document.querySelectorAll('a[href*="#lead-form"]'),
      function (a) {
        a.addEventListener('click', function () { window.gaEvent('nav_to_lead_form', {}); });
      }
    );

    // First interaction with any on-page calculator, fired once.
    var toolRoot = document.getElementById('emi-tool') || document.getElementById('eligibility-tool');
    if (toolRoot) {
      var fired = false;
      toolRoot.addEventListener('input', function () {
        if (fired) return;
        fired = true;
        window.gaEvent('tool_engaged', {});
      });
    }
  });
})();
</script>
