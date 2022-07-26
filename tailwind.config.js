/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php" // se agrega por que son recursos que usamos que necesitan los estilos de tailwind
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
