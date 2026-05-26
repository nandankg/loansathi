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
        // Brand primary — electric blue (CP-Advisor-ish)
        brand: {
          50:  '#eef4ff',
          100: '#d7e4ff',
          200: '#b1c8ff',
          300: '#7da2ff',
          400: '#4979f5',
          500: '#1e62d7',   // primary
          600: '#1450b8',
          700: '#0e3a85',
          800: '#0a2b62',
          900: '#091f47',
          DEFAULT: '#1e62d7',
        },
        // Vibrant orange — accent for CTAs and highlights
        accent: {
          50:  '#fff3ed',
          100: '#ffe1d0',
          200: '#ffbd9a',
          300: '#ff9763',
          400: '#ff7b40',
          500: '#ff6b35',   // accent
          600: '#e85a2c',
          700: '#bc4520',
          800: '#7f2f17',
          900: '#3f180c',
          DEFAULT: '#ff6b35',
        },
        // Friendly success green
        success: {
          50:  '#e9f9ef',
          400: '#22c55e',
          500: '#16a34a',
          600: '#15803d',
          DEFAULT: '#16a34a',
        },
        // Backgrounds
        surface: {
          DEFAULT: '#fbfcfe',
          50:  '#fbfcfe',
          100: '#f4f8fc',
          200: '#e9eff7',
        },
        ink: {
          DEFAULT: '#0a1a33',
          900: '#0a1a33',
          700: '#1f3358',
          500: '#4b5a78',
          400: '#697996',
          300: '#aeb7c8',
        },
      },
      fontFamily: {
        sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        display: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
      },
      boxShadow: {
        card: '0 4px 14px rgba(30, 98, 215, 0.08)',
        ring: '0 0 0 1px rgba(10, 26, 51, 0.06), 0 8px 24px -8px rgba(30, 98, 215, 0.18)',
        hero: '0 18px 40px -8px rgba(30, 98, 215, 0.25)',
        deep: '0 30px 64px -16px rgba(10, 26, 51, 0.35)',
        glow: '0 0 0 6px rgba(255, 107, 53, 0.15)',
      },
      backgroundImage: {
        'dots': "radial-gradient(circle at 1px 1px, rgba(30,98,215,0.18) 1px, transparent 0)",
        'grid': "linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px)",
        'glow-orange': "radial-gradient(circle at 30% 20%, rgba(255,107,53,0.18), transparent 55%)",
        'glow-blue': "radial-gradient(circle at 70% 30%, rgba(30,98,215,0.22), transparent 60%)",
      },
      animation: {
        'fade-up': 'fadeUp 700ms cubic-bezier(0.16, 1, 0.3, 1) both',
        'fade-in': 'fadeIn 800ms ease-out both',
        'float': 'float 6s ease-in-out infinite',
        'pulse-soft': 'pulseSoft 3.6s ease-in-out infinite',
        'spin-slow': 'spin 12s linear infinite',
      },
      keyframes: {
        fadeUp: { '0%': { opacity: '0', transform: 'translateY(18px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
        float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-8px)' } },
        pulseSoft: { '0%,100%': { opacity: '0.55' }, '50%': { opacity: '1' } },
      },
    },
  },
  plugins: [],
};
