# PLASCHEMA Website — Implementation Plan

> Derived from [PLASCHEMA_Website_PRD.md](./PLASCHEMA_Website_PRD.md) v1.0  
> Last updated: 2026-06-29

---

## Goals

Build a modern, secure, mobile-first public portal for the Plateau State Contributory Healthcare Management Agency (PLASCHEMA) that communicates trust, transparency, accessibility, professionalism, and simplicity — comparable to GOV.UK, NHS UK, Stripe, and modern SaaS experiences.

**In scope (v1):** Public website, design system, provider directory, content pages, digital service links, AI assistant (basic), admin/CMS for content, deployment pipeline.

**Out of scope (v1, nice-to-have per PRD):** Dark mode, hospital ratings, health tips blog, testimonials, video gallery, infographics, live chat, multilingual support.

---

## Tech Stack (Resolved)

The PRD lists some overlapping options. This plan standardizes on:

| Layer           | Choice                          | Notes                                                               |
| --------------- | ------------------------------- | ------------------------------------------------------------------- |
| Framework       | Laravel 12                      | Blade + Vite                                                        |
| Styling         | Tailwind CSS v4                 | 8-point spacing, design tokens                                      |
| UI components   | Shadcn UI                       | Adapted for Blade/Alpine                                            |
| Interactivity   | Alpine.js                       | Forms, accordions, modals                                           |
| Animation       | Framer Motion                   | Via React islands or Motion One for Blade — evaluate during Phase 1 |
| Icons           | Lucide                          | Consistent with PRD                                                 |
| Charts          | ApexCharts                      | Statistics on home + admin dashboards                               |
| Forms           | Tom Select, Flatpickr, FilePond | Searchable selects, dates, uploads                                  |
| Tables          | Grid.js                         | Admin content lists                                                 |
| Maps            | Google Maps JavaScript API      | Contact + provider pages                                            |
| Notifications   | Notyf + SweetAlert2             | Toasts + confirmations                                              |
| Rich text (CMS) | Tiptap                          | Lighter than TinyMCE; swap if preferred                             |
| Gallery         | LightGallery                    | About gallery, hospital photos                                      |
| Auth            | Laravel Sanctum                 | Admin/staff API sessions                                            |
| Database        | MySQL                           | All structured content                                              |
| Deployment      | Shared hosting + GitHub Actions | CI build, deploy artifact                                           |

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     Public Blade Frontend                    │
│  (Layouts, pages, Alpine.js, Tailwind, Shadcn-style tokens) │
└──────────────────────────┬──────────────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────────────┐
│              Laravel 12 Application Layer                    │
│  Controllers · Policies · Services · Sanctum API            │
└──────────────────────────┬──────────────────────────────────┘
                           │
┌──────────────────────────▼──────────────────────────────────┐
│                        MySQL                                 │
│  providers · plans · news · downloads · faqs · pages · users │
└─────────────────────────────────────────────────────────────┘

External: Google Maps API · Digital service portals (linked) · AI provider (TBD)
```

---

## Phase 0 — Project Foundation

**Objective:** Bootstrapped repo, tooling, and environment ready for feature work.

| Task                           | Details                                                      |
| ------------------------------ | ------------------------------------------------------------ |
| Initialize Laravel 12 project  | Fresh install, `.env.example`, app key                       |
| Configure Vite + Tailwind v4   | PostCSS, `@tailwindcss/vite`, content paths                  |
| Set up Shadcn-style tokens     | CSS variables for green/blue/orange, radius 16px, Inter font |
| Install core JS deps           | Alpine.js, Lucide, ApexCharts, Notyf, SweetAlert2            |
| MySQL schema planning          | Migration stubs for all entities                             |
| Git + GitHub Actions skeleton  | Lint/build on push; deploy workflow stub                     |
| Shared hosting constraints doc | PHP version, document root, cron, queue limits               |

**Deliverable:** `php artisan serve` + `npm run dev` runs; blank layout with design tokens applied.

---

## Phase 1 — Design System & Global Layout

**Objective:** Reusable UI foundation matching PRD design philosophy.

### Design tokens

- Primary: `#0B8F4D` · Secondary: `#1E88E5` · Accent: `#F59E0B` · Background: `#F8FAFC`
- Typography: Inter (headings large, body readable)
- Components: rounded buttons, card shadows, 8pt spacing scale

### Layout components

| Component               | Purpose                                                                |
| ----------------------- | ---------------------------------------------------------------------- |
| `layouts/app.blade.php` | Master layout                                                          |
| Header / nav            | Home, About, Health Plans, Enroll, Providers, News, Resources, Contact |
| Mobile nav              | Hamburger, slide/fade animation                                        |
| Footer                  | Quick links, newsletter, emergency numbers, social, legal links        |
| Breadcrumbs             | Inner pages                                                            |
| Section wrappers        | Consistent vertical rhythm                                             |
| CTA blocks              | Reusable call-to-action bands                                          |
| Stat cards              | Home statistics section                                                |
| Plan cards              | Pricing/plan display                                                   |
| Accordion               | FAQs                                                                   |
| Data table patterns     | Admin lists                                                            |

**Deliverable:** Static shell with nav/footer; placeholder home page proving responsive layout.

---

## Phase 2 — Public Pages (Static → Dynamic)

Build pages in order of user visibility and dependency.

### 2.1 Home

- Hero: background image, headline, 4 CTAs (Enroll, Verify, Find Hospital, Renew)
- Sections: Health Plans teaser, Statistics, Why PLASCHEMA, Success Stories, News, FAQs, final CTA
- Wire CTAs to correct routes/external URLs

### 2.2 About

- Mission, Vision, Objectives
- Director General profile
- Organogram (image or structured HTML)
- History timeline
- Photo gallery (LightGallery)

### 2.3 Health Insurance Plans

- Interactive pricing cards: Formal, Informal, Family, Student, Vulnerable (BHCPF)
- Benefits comparison table (responsive scroll on mobile)

### 2.4 News

- Listing: articles, health campaigns, activities, press releases
- Category filters + pagination
- Article detail template

### 2.5 Downloads (Resources)

- Categorized: Forms, Policies, Guidelines, Reports, Circulars
- File metadata: title, date, category, file type icon, download action

### 2.6 FAQs

- Categories, search (client-side or server), accordion UI

### 2.7 Contact

- Google Map embed
- Contact form (name, email, subject, message) with validation
- Office address, hotlines, email, social links

**Deliverable:** All public routes render with seed/static content; responsive and accessible.

---

## Phase 3 — Provider Directory

**Objective:** Interactive find-a-provider experience with map integration.

### Data model

`healthcare_providers`: name, LGA, specialty, ownership, services (JSON), address, phone, hours, photos, lat/lng, accreditation_status, slug

### Features

| Feature           | Implementation                                                |
| ----------------- | ------------------------------------------------------------- |
| Search page       | Filters: LGA, name, specialty, ownership, services            |
| List + map toggle | Split or tabbed view                                          |
| Map markers       | Google Maps JS API, clustered pins                            |
| Detail page       | Full provider info, photos, embedded map, accreditation badge |
| Admin CRUD        | Staff manage provider records                                 |

**Deliverable:** Searchable directory with ≥10 seed providers; detail pages with maps.

---

## Phase 4 — Admin / CMS

**Objective:** Staff can manage content without code deploys.

### Auth

- Sanctum session or web guard for admin
- Roles: `admin`, `editor` (minimum)

### Admin modules

| Module               | CRUD       | Notes                                   |
| -------------------- | ---------- | --------------------------------------- |
| Pages (About blocks) | ✓          | Mission, vision, DG, organogram         |
| Health plans         | ✓          | Plan cards + comparison rows            |
| Providers            | ✓          | Phase 3 model                           |
| News / articles      | ✓          | Tiptap body, categories, featured image |
| Downloads            | ✓          | FilePond upload, category               |
| FAQs                 | ✓          | Category, sort order                    |
| Home settings        | ✓          | Hero text, stats, featured stories      |
| Contact submissions  | Read       | Inbox for form messages                 |
| Users                | Admin only | Staff accounts                          |

### Admin UI

- Separate `layouts/admin.blade.php`
- Grid.js tables, Notyf feedback, SweetAlert2 delete confirms
- Dashboard with ApexCharts: enrollments (if data available), content counts

**Deliverable:** Authenticated admin panel managing all dynamic content.

---

## Phase 5 — Digital Services Hub

**Objective:** Interactive cards linking to external PLASCHEMA portals.

| Service                 | Action                           |
| ----------------------- | -------------------------------- |
| Online Enrollment       | External link (configurable URL) |
| Membership Verification | External link                    |
| Premium Payment         | External link                    |
| PLASCHEMA Support       | External link                    |

- Dedicated `/services` or section on Home
- Card hover animations, clear icons, opens in new tab where appropriate
- URLs stored in config or admin settings

**Deliverable:** Services grid live; URLs editable via admin or `.env`.

---

## Phase 6 — AI Assistant

**Objective:** Floating chatbot for common citizen questions.

### v1 scope (MVP)

- Floating button (bottom-right)
- Chat panel UI (Alpine.js)
- Scripted responses + FAQ keyword matching
- Topics: enrollment guide, find hospitals (link/search), plan explanations, FAQs

### v2 (post-launch)

- LLM integration (OpenAI / local) with RAG over PLASCHEMA content
- Rate limiting, privacy notice

**Deliverable:** Chatbot UI with useful static/keyword responses; architecture ready for LLM swap.

---

## Phase 7 — API Layer

**Objective:** REST API for future mobile apps and service integrations.

| Endpoint group  | Examples                                         |
| --------------- | ------------------------------------------------ |
| Public read     | `GET /api/plans`, `/providers`, `/news`, `/faqs` |
| Provider search | `GET /api/providers/search?lga=&specialty=`      |
| Contact         | `POST /api/contact`                              |
| Admin (Sanctum) | Full CRUD mirrors admin modules                  |

- API versioning: `/api/v1/`
- JSON resources, pagination, filtering
- Rate limiting on public endpoints

**Deliverable:** Documented API (OpenAPI or README); Sanctum-protected admin routes.

---

## Phase 8 — Quality, Accessibility & Performance

| Area          | Target                                                                       |
| ------------- | ---------------------------------------------------------------------------- |
| Accessibility | WCAG 2.1 AA — focus states, contrast, skip links, aria on accordions/nav     |
| SEO           | Meta tags, Open Graph, sitemap.xml, robots.txt                               |
| Performance   | Optimized images (WebP), lazy load, Vite build minification                  |
| Security      | CSRF, XSS sanitization (Tiptap output), file upload validation, HTTPS        |
| Testing       | Feature tests for routes, forms, API; browser smoke tests for critical paths |
| Analytics     | Google Analytics or Plausible (configurable)                                 |

**Deliverable:** Lighthouse ≥90 on mobile for home; accessibility audit pass list.

---

## Phase 9 — Deployment

| Step                 | Details                                                                  |
| -------------------- | ------------------------------------------------------------------------ |
| Production build     | `npm run build`, `php artisan config:cache`, `route:cache`, `view:cache` |
| Shared hosting setup | Document root → `public/`, symlink storage                               |
| GitHub Actions       | On `main`: test → build assets → deploy via FTP/SSH                      |
| Environment secrets  | DB, Maps API key, mail, external service URLs                            |
| Post-deploy          | Migrations, seed production content, smoke test URLs                     |
| Monitoring           | Uptime check, error logging (Laravel log + optional Sentry)              |

**Deliverable:** Live site on production domain with CI/CD documented in README.

---

## Database Entities (Summary)

```
users
pages / page_sections
health_plans / plan_benefits
healthcare_providers
news_articles
downloads
faqs / faq_categories
contact_messages
site_settings (hero, stats, service URLs, social links)
success_stories (optional v1)
```

---

## Suggested Build Order (Sprints)

| Sprint | Focus                                  | Duration (est.)                   |
| ------ | -------------------------------------- | --------------------------------- |
| 1      | Phase 0 + 1                            | Foundation, layout, design system |
| 2      | Phase 2 (Home, About, Contact)         | Core marketing pages              |
| 3      | Phase 2 (Plans, News, Downloads, FAQs) | Remaining public pages            |
| 4      | Phase 3                                | Provider directory + maps         |
| 5      | Phase 4                                | Admin CMS                         |
| 6      | Phase 5 + 6                            | Digital services + AI chatbot MVP |
| 7      | Phase 7 + 8                            | API, QA, accessibility            |
| 8      | Phase 9                                | Deploy + handoff                  |

---

## Open Questions / Decisions Needed

1. **Production domain & hosting** — exact provider, PHP version, SSH vs FTP deploy? Cpanel no SSH Access. use FTP via CICD github Actions deploy script
2. **External service URLs** — enrollment-https://enrollments.plaschema.app, verification-https://enrollments.plaschema.app/beneficiary-lookup, payment-https://enrollments.plaschema.app/pay/informal, support portal links-https://support.plaschema.app/support?
3. **Content** — who supplies copy, images, organogram, DG bio, seed provider data? Me
4. **AI assistant v1** — keyword/FAQ only, or budget for LLM API from launch? keyword/FAQ only
5. **Framer Motion** — pure Blade/Alpine may use Motion One instead; confirm animation approach. The best approach to be used
6. **Newsletter** — integrate Mailchimp/Brevo or store emails locally only? locally
7. **Email** — SMTP for contact form replies (which mail service)? cpanel
8. **Legal pages** — Privacy Policy, Terms, Accessibility Statement content source? No pages for any.

---

## Success Criteria (v1 Launch)

- [ ] All 8 public nav sections functional and mobile-responsive
- [ ] Provider search with map and detail pages
- [ ] Admin can publish news, FAQs, downloads, and manage providers
- [ ] Digital service cards link to correct external portals
- [ ] AI chatbot answers top FAQ topics
- [ ] Contact form delivers messages to staff
- [ ] Design matches token spec (colors, Inter, 16px radius, card UI)
- [ ] Deployed to production with CI/CD
- [ ] WCAG 2.1 AA baseline met on primary user journeys

---

## Related Files

- [PLASCHEMA_Website_PRD.md](./PLASCHEMA_Website_PRD.md) — source requirements
- [PROGRESS.md](./PROGRESS.md) — live task checklist and status
