export default defineNuxtConfig({
  app: {
    head: {
      title: 'Kanban Dashboard',
      bodyAttrs: {
        class: 'bg-body',
      },
      link: [
        {
          rel: 'shortcut icon',
          href: 'favicon.ico',
        },
      ],
    },
  },

  runtimeConfig: {
    public: {
      CLIENT_API_URL: process.env.CLIENT_API_URL,
    },
  },

  modules: ['@nuxtjs/tailwindcss'],

  tailwindcss: {
    cssPath: '~/assets/css/tailwind.scss',
  },
});
