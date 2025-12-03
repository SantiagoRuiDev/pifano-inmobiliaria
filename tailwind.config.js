/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.php",
    "./src/**/*.phtml",
    "./src/**/**/*.phtml",
    "./*.php",
    "./**/*.php",
    "./public/**/*.html"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}