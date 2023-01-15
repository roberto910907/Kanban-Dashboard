import tailwindTypography from '@tailwindcss/typography';
import tailwindForms from '@tailwindcss/forms';

export default {
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
  plugins: [tailwindTypography, tailwindForms],
};
