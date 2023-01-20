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

  vite: {
    server: {
      hmr: {
        protocol: 'wss',
        clientPort: 443,
        path: 'hmr/',
      },
    },
  },

  runtimeConfig: {
    public: {
      ENV: process.env.ENV,
      SENTRY_DSN: process.env.SENTRY_DSN,
    },
  },

  modules: ['@nuxtjs/tailwindcss', 'nuxt-icon'],

  tailwindcss: {
    cssPath: '~/assets/css/tailwind.scss',
  },
});
