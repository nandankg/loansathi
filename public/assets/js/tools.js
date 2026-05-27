// LoanSathi tool widgets — registered with Alpine on alpine:init.
// Loaded with `defer` BEFORE Alpine itself so this listener attaches first.

(function () {
  function emiCore(P, R, N) {
    if (P <= 0 || N <= 0) return 0;
    if (R === 0) return P / N;
    var r = R / 12 / 100;
    var pow = Math.pow(1 + r, N);
    return (P * r * pow) / (pow - 1);
  }

  var RATE_DEFAULTS = {
    personal: 10.5, home: 8.5, business: 12, gold: 9,
    lap: 9.5, education: 10, vehicle: 9.5,
  };
  var TENURE_DEFAULTS = {
    personal: 36, home: 240, business: 36, gold: 12,
    lap: 120, education: 84, vehicle: 60,
  };
  var AMOUNT_DEFAULTS = {
    personal: 500000, home: 5000000, business: 1500000, gold: 300000,
    lap: 3000000, education: 1500000, vehicle: 800000,
  };

  window.__leadPrefill = null;
  window.__leadAmount = null;

  function formatINR(n) {
    if (!isFinite(n)) return '0';
    return Math.round(n).toLocaleString('en-IN');
  }
  function formatAbbrev(n) {
    if (!isFinite(n) || n <= 0) return '₹0';
    if (n >= 10000000) return '₹' + (n / 10000000).toFixed(2) + ' Cr';
    if (n >= 100000)   return '₹' + (n / 100000).toFixed(1) + ' L';
    return '₹' + formatINR(n);
  }

  // --- Hero phone-mockup mini calc ---
  function emiHeroData() {
    return {
      amount: 1500000,
      rate: 9.5,
      tenure: 60,
      get emi() { return emiCore(this.amount, this.rate, this.tenure); },
      get principalPct() {
        var totalPay = this.emi * this.tenure;
        return totalPay > 0 ? (this.amount / totalPay) * 100 : 0;
      },
      formatINR: formatINR,
      formatAbbrev: formatAbbrev,
    };
  }

  // --- Full EMI calculator ---
  function emiCalcData() {
    return {
      loanType: 'personal',
      amount: 500000,
      rate: 10.5,
      tenure: 36,
      syncDefaults: function () {
        this.amount = AMOUNT_DEFAULTS[this.loanType] || this.amount;
        this.rate   = RATE_DEFAULTS[this.loanType]   || this.rate;
        this.tenure = TENURE_DEFAULTS[this.loanType] || this.tenure;
      },
      get emi() { return Math.round(emiCore(this.amount, this.rate, this.tenure)); },
      get totalPayment() { return this.emi * this.tenure; },
      get totalInterest() { return Math.max(0, this.totalPayment - this.amount); },
      get principalPct() {
        return this.totalPayment > 0 ? (this.amount / this.totalPayment) * 100 : 0;
      },
      formatNum: formatINR,
      prefillLeadForm: function () {
        window.__leadPrefill = this.loanType;
        window.__leadAmount = this.amount;
      },
    };
  }

  // --- Eligibility checker ---
  function eligibilityCheckData() {
    return {
      loanType: 'personal',
      income: 60000,
      existingEmi: 0,
      age: 30,
      score: 'good',
      get result() {
        var inc = +this.income || 0;
        var emi = +this.existingEmi || 0;
        if (inc <= 0) {
          return { eligible: false, amount: 0, message: 'Enter your monthly income to see eligibility.' };
        }
        var amount = 0, eligible = false, message = '';
        switch (this.loanType) {
          case 'personal': {
            if (this.age < 21 || this.age > 60) {
              message = 'Age must be 21–60 for personal loans.';
              break;
            }
            if (this.score === 'below_650') {
              message = 'Score below 650 typically disqualifies personal loans. Try gold/LAP instead.';
              break;
            }
            var capacity = 24 * inc - 12 * emi;
            if (capacity <= 0) {
              message = 'Existing EMIs leave no repayment headroom.';
              break;
            }
            amount = capacity;
            eligible = true;
            message = 'Based on your income & EMI capacity. Final offer depends on credit history.';
            break;
          }
          case 'home': {
            var maxEmi = inc * 0.55 - emi;
            if (maxEmi <= 0) {
              message = 'Existing EMIs leave no headroom for a home loan.';
              break;
            }
            var r = 8.5 / 12 / 100, n = 240, pow = Math.pow(1 + r, n);
            amount = maxEmi * (pow - 1) / (r * pow);
            eligible = true;
            message = 'Assumes 8.5% over 20 years. Longer tenure increases the eligible amount.';
            break;
          }
          case 'business':
            amount = inc * 12 * 0.30;
            eligible = inc > 0;
            message = 'Indicative — based on 30% of estimated annual turnover.';
            break;
          case 'gold':
            amount = 450000;
            eligible = true;
            message = 'Gold loans depend on weight × value × 75% LTV. ₹4.5L shown for ~100g at ₹6,000/g.';
            break;
          case 'lap':
            amount = 6500000;
            eligible = true;
            message = 'Loan Against Property typically goes up to 65% of property value.';
            break;
          case 'education':
            amount = this.score === 'below_650' ? 750000 : 5000000;
            eligible = true;
            message = 'Without collateral, capped at ₹7.5L. With collateral or co-applicant, up to ₹50L.';
            break;
          case 'vehicle':
            amount = 680000;
            eligible = true;
            message = 'Up to 85% of on-road price. Some lenders cover 90% on select models.';
            break;
          default:
            message = 'Select a loan type to see your eligibility.';
        }
        return { eligible: eligible, amount: Math.round(amount), message: message };
      },
      formatNum: function (n) {
        if (!isFinite(n) || n <= 0) return '0';
        if (n >= 10000000) return (n / 10000000).toFixed(2) + ' Cr';
        if (n >= 100000)   return (n / 100000).toFixed(1) + ' L';
        return Math.round(n).toLocaleString('en-IN');
      },
      prefillLeadForm: function () {
        window.__leadPrefill = this.loanType;
        window.__leadAmount = this.result.amount;
      },
    };
  }

  // --- Wire prefill into the lead form after Alpine inits ---
  document.addEventListener('alpine:init', function () {
    window.Alpine.data('emiHero', emiHeroData);
    window.Alpine.data('emiCalc', emiCalcData);
    window.Alpine.data('eligibilityCheck', eligibilityCheckData);
  });

  // Click handler — prefill loan_type and amount in the lead form
  document.addEventListener('click', function (ev) {
    var a = ev.target.closest('a[href="#lead-form"]');
    if (!a) return;
    var lt = window.__leadPrefill;
    if (!lt) return;
    setTimeout(function () {
      var root = document.getElementById('lead-form');
      if (!root || !window.Alpine) return;
      var data = window.Alpine.$data(root);
      if (data && data.form) {
        if (RATE_DEFAULTS[lt]) data.form.loan_type = lt;
        if (window.__leadAmount) data.form.loan_amount = window.__leadAmount;
      }
    }, 0);
  });

  function setText(root, selector, text) {
    var el = root.querySelector(selector);
    if (el) el.textContent = text;
  }

  function setupToolTabs() {
    var tabs = Array.prototype.slice.call(document.querySelectorAll('[data-tool-tab]'));
    var panels = Array.prototype.slice.call(document.querySelectorAll('[data-tool-panel]'));
    if (!tabs.length || !panels.length) return;

    function activate(name) {
      tabs.forEach(function (tab) {
        tab.classList.toggle('active', tab.getAttribute('data-tool-tab') === name);
      });
      panels.forEach(function (panel) {
        panel.style.display = panel.getAttribute('data-tool-panel') === name ? '' : 'none';
      });
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        activate(tab.getAttribute('data-tool-tab'));
      });
    });

    activate('emi');
  }

  function numberValue(root, field, fallback) {
    var el = root.querySelector('[data-emi-field="' + field + '"], [data-elig-field="' + field + '"]');
    var value = el ? parseFloat(el.value) : NaN;
    return isFinite(value) ? value : fallback;
  }

  function syncFields(root, attr, field, value) {
    Array.prototype.slice.call(root.querySelectorAll('[' + attr + '="' + field + '"]')).forEach(function (el) {
      el.value = value;
    });
  }

  function setupEmiFallback() {
    var root = document.getElementById('emi-tool');
    if (!root) return;
    var calculate = root.querySelector('[data-emi-calculate]');
    var loanType = root.querySelector('[data-emi-field="loanType"]');

    function updateResult() {
      var amount = numberValue(root, 'amount', 0);
      var rate = numberValue(root, 'rate', 0);
      var tenure = numberValue(root, 'tenure', 0);
      var emi = Math.round(emiCore(amount, rate, tenure));
      var totalPayment = Math.round(emi * tenure);
      var totalInterest = Math.max(0, totalPayment - amount);
      var principalPct = totalPayment > 0 ? Math.max(0, Math.min(100, (amount / totalPayment) * 100)) : 0;

      setText(root, '[data-emi-result="emi"]', '₹' + formatINR(emi));
      setText(root, '[data-emi-result="amount"]', formatINR(amount));
      setText(root, '[data-emi-result="totalInterest"]', '₹' + formatINR(totalInterest));
      setText(root, '[data-emi-result="totalPayment"]', '₹' + formatINR(totalPayment));
      setText(root, '[data-emi-result="principalPct"]', principalPct.toFixed(0) + '%');
      var circle = root.querySelector('[data-emi-circle]');
      if (circle) circle.setAttribute('stroke-dashoffset', String(100 - principalPct));

      window.__leadPrefill = loanType ? loanType.value : 'personal';
      window.__leadAmount = amount;
    }

    Array.prototype.slice.call(root.querySelectorAll('[data-emi-field]')).forEach(function (el) {
      el.addEventListener('input', function () {
        var field = el.getAttribute('data-emi-field');
        if (field !== 'loanType') syncFields(root, 'data-emi-field', field, el.value);
      });
      el.addEventListener('change', function () {
        var field = el.getAttribute('data-emi-field');
        if (field === 'loanType') {
          syncFields(root, 'data-emi-field', 'amount', AMOUNT_DEFAULTS[el.value] || 500000);
          syncFields(root, 'data-emi-field', 'rate', RATE_DEFAULTS[el.value] || 10.5);
          syncFields(root, 'data-emi-field', 'tenure', TENURE_DEFAULTS[el.value] || 36);
        }
      });
    });

    if (calculate) calculate.addEventListener('click', updateResult);
    updateResult();
  }

  function eligibilityResult(loanType, income, existingEmi, age, score) {
    if (income <= 0) {
      return { eligible: false, amount: 0, message: 'Enter your monthly income to see eligibility.' };
    }
    var amount = 0, eligible = false, message = '';
    switch (loanType) {
      case 'personal':
        if (age < 21 || age > 60) return { eligible: false, amount: 0, message: 'Age must be 21-60 for personal loans.' };
        if (score === 'below_650') return { eligible: false, amount: 0, message: 'Score below 650 typically disqualifies personal loans. Try gold or LAP instead.' };
        amount = 24 * income - 12 * existingEmi;
        eligible = amount > 0;
        message = eligible ? 'Based on your income and EMI capacity. Final offer depends on credit history.' : 'Existing EMIs leave no repayment headroom.';
        break;
      case 'home': {
        var maxEmi = income * 0.55 - existingEmi;
        if (maxEmi <= 0) return { eligible: false, amount: 0, message: 'Existing EMIs leave no headroom for a home loan.' };
        var r = 8.5 / 12 / 100, n = 240, pow = Math.pow(1 + r, n);
        amount = maxEmi * (pow - 1) / (r * pow);
        eligible = true;
        message = 'Assumes 8.5% over 20 years. Longer tenure increases the eligible amount.';
        break;
      }
      case 'business':
        amount = income * 12 * 0.30;
        eligible = true;
        message = 'Indicative, based on 30% of estimated annual turnover.';
        break;
      case 'gold':
        amount = 450000;
        eligible = true;
        message = 'Gold loans depend on weight, value, and lender LTV.';
        break;
      case 'lap':
        amount = 6500000;
        eligible = true;
        message = 'Loan Against Property typically goes up to 65% of property value.';
        break;
      case 'education':
        amount = score === 'below_650' ? 750000 : 5000000;
        eligible = true;
        message = 'Without collateral, capped near ₹7.5L. With collateral or co-applicant, higher limits may be possible.';
        break;
      case 'vehicle':
        amount = 680000;
        eligible = true;
        message = 'Vehicle loans can cover up to about 85% of on-road price.';
        break;
      default:
        message = 'Select a loan type to see your eligibility.';
    }
    return { eligible: eligible, amount: Math.round(Math.max(0, amount)), message: message };
  }

  function setupEligibilityFallback() {
    var root = document.getElementById('eligibility-tool');
    if (!root) return;
    var calculate = root.querySelector('[data-elig-calculate]');
    var selectedLoan = 'personal';

    function markSelected() {
      Array.prototype.slice.call(root.querySelectorAll('[data-elig-loan]')).forEach(function (btn) {
        var active = btn.getAttribute('data-elig-loan') === selectedLoan;
        btn.classList.toggle('!bg-brand-500', active);
        btn.classList.toggle('!text-white', active);
        btn.classList.toggle('!border-brand-500', active);
      });
    }

    function updateResult() {
      var income = numberValue(root, 'income', 0);
      var existingEmi = numberValue(root, 'existingEmi', 0);
      var age = numberValue(root, 'age', 30);
      var scoreEl = root.querySelector('[data-elig-field="score"]');
      var score = scoreEl ? scoreEl.value : 'good';
      var result = eligibilityResult(selectedLoan, income, existingEmi, age, score);

      setText(root, '[data-elig-result="amount"]', result.eligible ? formatAbbrev(result.amount) : '—');
      setText(root, '[data-elig-result="message"]', result.message);
      window.__leadPrefill = selectedLoan;
      window.__leadAmount = result.amount;
      markSelected();
    }

    Array.prototype.slice.call(root.querySelectorAll('[data-elig-loan]')).forEach(function (btn) {
      btn.addEventListener('click', function () {
        selectedLoan = btn.getAttribute('data-elig-loan');
        markSelected();
      });
    });

    if (calculate) calculate.addEventListener('click', updateResult);
    markSelected();
    updateResult();
  }

  document.addEventListener('DOMContentLoaded', function () {
    setupToolTabs();
    setupEmiFallback();
    setupEligibilityFallback();
  });
})();
