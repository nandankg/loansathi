/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './src/**/*.php',
    './public/**/*.php',
    './public/assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#0a2540',
          900: '#0a2540',
          800: '#0f3460',
          700: '#15406b',
          ink: '#061a2c',
        },
        saffron: {
          DEFAULT: '#ff8a3d',
          50: '#fff5ed',
          100: '#ffe6d2',
          400: '#ff8a3d',
          500: '#f57c2a',
          600: '#d96918',
          700: '#a14e10',
        },
        cream: {
          DEFAULT: '#fbf7ef',
          50: '#fefcf7',
          100: '#fbf7ef',
          200: '#f4ecd9',
        },
        brand: {
          blue: '#1e88e5',
          amber: '#f59e0b',
          slate: '#475569',
          surface: '#f7fafc',
        },
      },
      fontFamily: {
        sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['Fraunces', 'Georgia', 'serif'],
        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
      },
      boxShadow: {
        card: '0 4px 14px rgba(10, 37, 64, 0.08)',
        hero: '0 12px 32px rgba(10, 37, 64, 0.18)',
        deep: '0 24px 60px -16px rgba(10, 37, 64, 0.35)',
        ring: '0 0 0 1px rgba(10, 37, 64, 0.06), 0 8px 24px -8px rgba(10, 37, 64, 0.18)',
      },
      backgroundImage: {
        'noise': "url(\"data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='2' stitchTiles='stitch'/%3E%3CfeColorMatrix values='0 0 0 0 0  0 0 0 0 0  0 0 0 0 0  0 0 0 0.06 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E\")",
        'grid': "linear-gradient(to right, rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.04) 1px, transparent 1px)",
        'radial-amber': "radial-gradient(circle at 30% 20%, rgba(255,138,61,0.18), transparent 55%)",
      },
      animation: {
        'fade-up': 'fadeUp 700ms cubic-bezier(0.16, 1, 0.3, 1) both',
        'fade-in': 'fadeIn 800ms ease-out both',
        'marquee': 'marquee 28s linear infinite',
        'pulse-soft': 'pulseSoft 3.6s ease-in-out infinite',
      },
      keyframes: {
        fadeUp: { '0%': { opacity: '0', transform: 'translateY(18px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
        marquee: { '0%': { transform: 'translateX(0)' }, '100%': { transform: 'translateX(-50%)' } },
        pulseSoft: { '0%,100%': { opacity: '0.6' }, '50%': { opacity: '1' } },
      },
    },
  },
  plugins: [],
};
