module.exports = {
  purge: [
  './storage/framework/views/*.php',
  './resources/**/*.blade.php',
  './resources/**/*.js',
  './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      main: {
        light: '#D0FBF8',
        DEFAULT: '#15ebde'
      },
      gray: {
        light: '#999999',
        DEFAULT: '#999999'
      },
      black: {
        DEFAULT: '#555555'
      },
      orange: {
        DEFAULT: '#FF6347'
      }
    },
    extend: {

    },
  },
  variants: {
  extend: {},
  },
  plugins: [],
  }