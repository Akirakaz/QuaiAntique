/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './templates/**/*.{twig,html.twig}',
    './assets/js/**/*.{js,jsx,ts,tsx,vue}'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
