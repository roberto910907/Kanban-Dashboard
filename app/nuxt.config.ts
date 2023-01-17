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
      ENV: process.env.ENV,
      SENTRY_DSN: process.env.SENTRY_DSN,
    },
  },

  modules: ['@nuxtjs/tailwindcss'],

  tailwindcss: {
    cssPath: '~/assets/css/tailwind.scss',
  },
});
