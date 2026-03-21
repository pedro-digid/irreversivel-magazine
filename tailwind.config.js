// tailwind.config.js
/** @type {import('tailwindcss').Config} */
const plugin = require('tailwindcss/plugin');

module.exports = {
  darkMode: 'class',
  content: [
    './**/*.php',
    './src/**/*.{js,jsx}',
  ],
  theme: {
    container: {
      center: true,
      padding: '1.5rem',
    },
    fontFamily: {
      sans: ['"DM Sans Variable"', 'system-ui', 'sans-serif'],
      display: ['"Space Grotesk Variable"', 'system-ui', 'sans-serif'],
    },
    extend: {
      colors: {
        bg: 'var(--color-bg)',
        text: 'var(--color-text)',
        'text-muted': 'var(--color-text-muted)',
        primary: 'var(--color-primary)',
        border: 'var(--color-border)',
      },
    },
  },
  plugins: [
    plugin(function ({ addComponents }) {
      addComponents({
        '.container-fluid': {
          width: '100%',
          paddingLeft: '1.5rem',
          paddingRight: '1.5rem',
          marginLeft: 'auto',
          marginRight: 'auto',
        },
        '.theme-grid': {
          display: 'grid',
          gridTemplateColumns: 'repeat(12, minmax(0, 1fr))',
          gap: '1.5rem',
        },
      });
    }),
  ],
}