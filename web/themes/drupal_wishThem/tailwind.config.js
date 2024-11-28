/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./templates/**/*.twig",
  ],

  theme: {
    extend: {
      fontFamily: {
        header: ["Faculty Glyphic", 'sans-serif'],
        title: ["Luckiest Guy", "cursive"],
        post: ["Lexend Deca", 'sans-serif'],
        article: ["Beiruti", 'sans-serif'],
        form: ["Roboto Flex", 'sans-serif'],
      },
    },
  },
  plugins: [],
}

