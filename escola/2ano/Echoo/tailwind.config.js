/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      backgroundImage:{
        logoDark:"url('../images/logo-dark-recorte4.png')" ,
        logoLight:"url('../images/logo-light-recorte4.png')",
      },
    },
  },
  plugins: [],
}

