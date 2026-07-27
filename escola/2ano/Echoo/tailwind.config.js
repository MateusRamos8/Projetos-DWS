/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      backgroundImage:{
        logoDark:"url('../images/logo-dark-recorte4.png')" ,
        logoLight:"url('../images/logo-light-recorte4.png')",
      },
      typography: {
        modal:{
          css:{
            h1: { fontSize: '2.5rem', fontWeight: 'bold', margin: '1rem 0' },
            h2: { fontSize: '2.25rem', fontWeight: 'bold', margin: '1rem 0' },
            h3: { fontSize: '2rem', fontWeight: 'bold', margin: '1rem 0' },
            h4: { fontSize: '1.75rem', fontWeight: 'bold', margin: '1rem 0' },
            h5: { fontSize: '1.5rem', fontWeight: 'bold', margin: '1rem 0' },
            h6: { fontSize: '1.25rem', fontWeight: 'bold', margin: '1rem 0' },
          }
        }
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}

