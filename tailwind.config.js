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
      },
      boxShadow: {
        card: '0 4px 14px rgba(10, 37, 64, 0.08)',
        hero: '0 12px 32px rgba(10, 37, 64, 0.18)',
      },
    },
  },
  plugins: [],
};
