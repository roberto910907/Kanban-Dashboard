// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      CLIENT_API_URL: process.env.CLIENT_API_URL
    }
  },

  css: [
    '@/assets/css/app.scss',
  ]
})
