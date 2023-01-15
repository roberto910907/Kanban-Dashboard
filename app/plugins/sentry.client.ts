import * as Sentry from '@sentry/browser';
import { Integrations } from '@sentry/tracing';

export default defineNuxtPlugin((nuxtApp) => {
  const dsn = nuxtApp.$config.SENTRY_DSN;
  const environment = nuxtApp.$config.ENV;

  if (environment === 'production') {
    Sentry.init({
      dsn,
      environment,
      integrations: [new Integrations.BrowserTracing()],
      sampleRate: 1,
      tracesSampleRate: 0,
    });
  }
});
