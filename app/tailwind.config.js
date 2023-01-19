import tailwindTypography from '@tailwindcss/typography';
import tailwindForms from '@tailwindcss/forms';

export default {
  content: [
    './components/**/*.{js,vue,ts}',
    './layouts/**/*.vue',
    './pages/**/*.vue',
    './plugins/**/*.{js,ts}',
    './nuxt.config.{js,ts}',
    './node_modules/flowbite.{js,ts}',
  ],
  theme: {
    extend: {
      colors: {
        body: '#fff',
        navbar: '#49576b',
        column: '#dfe5eb',
        icon: '#7a92a5',
      },
    },
  },
  plugins: [tailwindTypography, tailwindForms, require('flowbite')],
};
