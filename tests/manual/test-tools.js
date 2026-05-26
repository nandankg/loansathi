// Standalone test for the tools JS logic
function emiCore(P, R, N) {
  if (P <= 0 || N <= 0) return 0;
  if (R === 0) return P / N;
  const r = R / 12 / 100;
  const pow = Math.pow(1 + r, N);
  return (P * r * pow) / (pow - 1);
}

const RATE_DEFAULTS = { personal: 10.5, home: 8.5, business: 12, gold: 9, lap: 9.5, education: 10, vehicle: 9.5 };
const TENURE_DEFAULTS = { personal: 36, home: 240, business: 36, gold: 12, lap: 120, education: 84, vehicle: 60 };
const AMOUNT_DEFAULTS = { personal: 500000, home: 5000000, business: 1500000, gold: 300000, lap: 3000000, education: 1500000, vehicle: 800000 };

function emiCalc() {
  return {
    loanType: 'personal',
    amount: 500000,
    rate: 10.5,
    tenure: 36,
    syncDefaults() {
      this.amount = AMOUNT_DEFAULTS[this.loanType];
      this.rate = RATE_DEFAULTS[this.loanType];
      this.tenure = TENURE_DEFAULTS[this.loanType];
    },
    get emi() { return Math.round(emiCore(this.amount, this.rate, this.tenure)); },
    get totalPayment() { return this.emi * this.tenure; },
    get totalInterest() { return Math.max(0, this.totalPayment - this.amount); },
    get principalPct() { return this.totalPayment > 0 ? (this.amount / this.totalPayment) * 100 : 0; },
    formatNum(n) { return Math.round(n).toLocaleString('en-IN'); },
  };
}

const c = emiCalc();
c.amount = 800000; c.rate = 11; c.tenure = 18;
console.log('emi:', c.emi, '=', c.formatNum(c.emi));
console.log('totalPayment:', c.totalPayment, '=', c.formatNum(c.totalPayment));
console.log('totalInterest:', c.totalInterest, '=', c.formatNum(c.totalInterest));
console.log('principalPct:', c.principalPct.toFixed(1) + '%');
