# Kanban Dashboard
**Demo**: https://kanbandash.com/

**Docs**: [WIP]

## Project Scope
The current project aims to create an open-source Kanban Dashboard with some of the most common features included.

## Structure
- **api** folder: Laravel 9 application serving a GraphQL endpoint
- **app** folder: Nuxt 3 application serving frontend

## Task List
- [ ] Create documentation site using Nuxt docs package
- [x] Refactor application code with TailwindCSS
- [ ] Introduce GraphQL instead of the REST API
- [x] Migrate to Nuxt framework(v3)
- [ ] Add new icon library(mdi-icons)
- [ ] Introduce Tailwind Components
- [ ] Migrate to multi-tenant database
- [ ] Add register page
- [ ] Add login page
- [ ] Add multiple dashboards
- [ ] Protect API with token
- [ ] Add dashboard filters(date, status, etc)
- [ ] Add assigned users

## DevOps Tasks
- [ ] Configure monitoring tools(Sentry, Datadog, Better Uptime)
- [ ] Activate OPCache
- [ ] PHP-FPM restart should not be needed
- [ ] Cloudflare CDN
- [ ] Register should create a new DO subdomain

## Screenshot
![Screenshot](./api/public/img/screenshot.png)
