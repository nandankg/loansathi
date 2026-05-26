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
})();
