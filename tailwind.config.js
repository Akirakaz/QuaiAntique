/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.{twig,html.twig}",
    "./assets/js/**/*.{js,jsx,ts,tsx,vue}",
  ],
  theme: {
    extend: {
      fontFamily: {
        playball: ["Playball", "sans-serif"],
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
        'screen-fhd': '1920px'
      },
      screens: {
        'xs': '414px',
      }
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
