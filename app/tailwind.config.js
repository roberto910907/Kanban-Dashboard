import tailwindTypography from '@tailwindcss/typography';
import tailwindForms from '@tailwindcss/forms';
import flowbite from 'flowbite';

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
        body: '#f5f5f5',
        navbar: '#49576b',
        column: '#e2e4e6',
        title: '#333333',
      },
    },
  },
  plugins: [tailwindTypography, tailwindForms, flowbite],
};
