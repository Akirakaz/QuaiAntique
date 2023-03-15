/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.{twig,html.twig}",
    "./assets/js/**/*.{js,jsx,ts,tsx,vue}",
  ],
  theme: {
    extend: {
      fontFamily: {
        parisienne: ["Parisienne", "sans-serif"],
        adrenalines: ["Adrenalines", "sans-serif"],
        playball: ["Playball", "sans-serif"],
      },
      backgroundImage: {
        'banner': "url('./assets/img/top-banner.jpg')",
      },
      zIndex: {
        1: "1",
        2: "2",
        3: "3",
        4: "4",
        5: "5",
      },
      maxWidth: {
        '8xl': '90rem',
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
