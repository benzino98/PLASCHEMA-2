# PLASCHEMA Website — Progress Tracker

> Update this file as tasks are completed.  
> Plan reference: [IMPLEMENTATION_PLAN.md](./IMPLEMENTATION_PLAN.md)  
> Last updated: 2026-07-26

**Overall status:** Phase 7 complete  
**Current phase:** Phase 8 — Quality, Accessibility & Performance  
**Target v1 launch:** TBD

---

## Status Legend

| Symbol | Meaning |
|--------|---------|
| ⬜ | Not started |
| 🔄 | In progress |
| ✅ | Complete |
| ⏸️ | Blocked |
| ⏭️ | Deferred (nice-to-have) |

---

## Phase 0 — Project Foundation

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Initialize Laravel 12 project | | Laravel 13.8 installed (latest stable; PRD said 12) |
| ✅ | Configure Vite + Tailwind CSS v4 | | Tailwind v4 + `@tailwindcss/vite` |
| ✅ | Set up design tokens (colors, radius, spacing, Inter) | | `resources/css/app.css` |
| ✅ | Install Alpine.js, Lucide, core JS libraries | | + ApexCharts, Notyf, SweetAlert2, Motion |
| ✅ | MySQL connection + initial migrations planned | | `.env.example` + `database/SCHEMA_PLAN.md` |
| ✅ | Git repository initialized | | |
| ✅ | GitHub Actions CI skeleton (lint + build) | | `.github/workflows/ci.yml` + `deploy.yml` |
| ✅ | Document shared hosting requirements | | `docs/HOSTING.md` |

**Phase 0 progress:** 8 / 8 ✅

---

## Phase 1 — Design System & Global Layout

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Master layout (`layouts/app.blade.php`) | | |
| ✅ | Header + desktop navigation | | 8 nav items per PRD |
| ✅ | Mobile navigation (animated) | | Alpine.js slide-in panel |
| ✅ | Footer (links, newsletter, emergency, social) | | No legal pages (per decision) |
| ✅ | Reusable components: buttons, cards, CTAs, stat cards | | + plan-card component |
| ✅ | Breadcrumbs component | | `components/breadcrumbs` |
| ✅ | Accordion component (FAQs) | | Alpine.js toggle |
| ✅ | Admin layout shell | | `layouts/admin.blade.php` + `/admin` |
| ✅ | Responsive smoke test (mobile / tablet / desktop) | | Feature tests + build pass |

**Phase 1 progress:** 9 / 9 ✅

---

## Phase 2 — Public Pages

### Home
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Hero section (image, headline, 4 CTAs) | | Gradient + background image |
| ✅ | Health Plans teaser section | | From database |
| ✅ | Statistics section (ApexCharts) | | Enrollment growth chart |
| ✅ | Why Choose PLASCHEMA section | | 4 feature cards |
| ✅ | Success Stories section | | 3 seeded stories |
| ✅ | News preview section | | Latest 3 articles |
| ✅ | FAQs preview section | | Accordion with 4 FAQs |
| ✅ | Bottom call-to-action section | | Gradient CTA band |

### About
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Mission, Vision, Objectives | | Page sections in DB |
| ✅ | Director General profile | | Placeholder — replace with real bio |
| ✅ | Organogram | | Structural placeholder |
| ✅ | History section | | Timeline from DB |
| ✅ | Photo gallery (LightGallery) | | 6 images with lightbox |

### Health Insurance Plans
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Plan pricing cards (5 plan types) | | All 5 plans seeded |
| ✅ | Benefits comparison table | | `x-benefits-table` component |
| ✅ | Mobile-responsive table scroll | | Horizontal scroll on mobile |

### News
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | News listing with categories | | Filter pills + pagination |
| ✅ | Article detail page | | `/news/{slug}` |
| ✅ | Pagination | | Laravel paginator |

### Downloads (Resources)
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Categorized download listing | | Grouped by category |
| ✅ | File download action | | `/resources/{slug}/download` |

### FAQs
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Category grouping | | 4 categories seeded |
| ✅ | Search functionality | | Alpine.js client-side filter |
| ✅ | Accordion UI | | Per-question toggle |

### Contact
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Google Map embed | | Jos, Plateau State embed |
| ✅ | Contact form + validation | | Stores to `contact_messages` |
| ✅ | Office info, hotlines, email, social | | From config |

**Phase 2 progress:** 24 / 24 ✅

---

## Phase 3 — Provider Directory

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | `healthcare_providers` migration + model | | + photos table |
| ✅ | Provider search page with filters | | LGA, name, specialty, ownership, service |
| ✅ | List view | | Card grid with accreditation badges |
| ✅ | Map view (Google Maps API) | | Interactive markers when API key set; embed fallback |
| ✅ | Provider detail page | | Contact, services, map, related providers |
| ✅ | Seed data (≥10 providers) | | 12 providers across 8 LGAs |
| ✅ | Admin CRUD for providers | | `/admin/providers` create/edit/delete |

**Phase 3 progress:** 7 / 7 ✅

---

## Phase 4 — Admin / CMS

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Admin authentication (Sanctum / web guard) | | Laravel web guard + session auth, login/logout flow |
| ✅ | Role-based access (admin, editor) | | `role` column + `EnsureUserHasRole` middleware + helper methods |
| ✅ | Dashboard with summary stats | | 8 stat cards, ApexCharts enrollment graph, recent activity feeds |
| ✅ | Manage pages (About content) | | Structured mission, vision, objectives, DG profile, history, and gallery editor |
| ✅ | Manage health plans | | CRUD with transactional repeatable benefit management |
| ✅ | Manage news articles (Tiptap) | | Rich editor, HTML allowlist sanitizer, publication workflow, featured images |
| ✅ | Manage downloads (FilePond) | | Validated document uploads, metadata, replacement and deletion cleanup |
| ✅ | Manage FAQs | | Searchable/filterable CRUD, publication status, ordering, and tests |
| ✅ | Manage home settings (hero, stats) | | Hero, impact stats, enrollment chart, and Why PLASCHEMA cards |
| ✅ | Contact message inbox | | Listing with filters, read/unread status, detail view, mark as read/unread |
| ✅ | User management (admin only) | | Admin/editor accounts with self-deletion and final-admin guards |
| ✅ | Grid.js data tables in admin | | Progressive sorting/search enhancement on CMS tables |

**Phase 4 progress:** 12 / 12 ✅

---

## Phase 5 — Digital Services Hub

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Services page / home section with interactive cards | | Dedicated `/services` hub plus reusable homepage grid |
| ✅ | Online Enrollment link (configurable) | | `SiteSetting` override with `.env` config fallback |
| ✅ | Membership Verification link | | Secure external link with new-tab semantics |
| ✅ | Premium Payment link | | Secure external link with new-tab semantics |
| ✅ | PLASCHEMA Support link | | Secure external link with new-tab semantics |
| ✅ | Admin/config for external URLs | | Validated admin settings editor + centralized service registry |

**Phase 5 progress:** 6 / 6 ✅

---

## Phase 6 — AI Assistant

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | Floating chat button UI | | Animated launcher with pulse ring, responsive positioning, reduced-motion support |
| ✅ | Chat panel (Alpine.js) | | Deterministic component, keyboard Escape, focus return, live region, quick prompts |
| ✅ | Enrollment guide responses | | Curated trust-marked reply with portal link |
| ✅ | Find hospitals helper (link to search) | | Provider search page route with contextual link |
| ✅ | Plan explanation responses | | Published plan list with names, descriptions, pricing |
| ✅ | FAQ keyword matching | | Token-based term scoring against published FAQ questions/answers |
| ⏭️ | LLM integration (v2) | | Post-launch deferred |

**Phase 6 progress:** 6 / 6 ✅ (v1 scope)

---

## Phase 7 — API Layer

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ✅ | API v1 route structure | | 34 routes under `/api/v1` with named throttling tiers |
| ✅ | Public read endpoints (plans, providers, news, faqs) | | Explicit JSON resources, pagination, publication boundaries |
| ✅ | Provider search endpoint | | Query, LGA, specialty, ownership, service filters |
| ✅ | Contact form endpoint | | Shared validation; 5 submissions/min/IP |
| ✅ | Sanctum-protected admin API | | Token lifecycle, admin/editor content roles, stale-ability protection |
| ✅ | API documentation | | OpenAPI 3.1 + curl quick-start and endpoint matrix |

**Phase 7 progress:** 6 / 6 ✅

---

## Phase 8 — Quality, Accessibility & Performance

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | WCAG 2.1 AA audit (primary journeys) | | |
| ⬜ | SEO meta tags + Open Graph | | |
| ⬜ | sitemap.xml + robots.txt | | |
| ⬜ | Image optimization (WebP, lazy load) | | |
| ⬜ | Security review (CSRF, uploads, XSS) | | |
| ⬜ | Feature tests (routes, forms, API) | | |
| ⬜ | Lighthouse mobile ≥ 90 (home) | | |
| ⬜ | Analytics integration | | |

**Phase 8 progress:** 0 / 8

---

## Phase 9 — Deployment

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Production environment configured | | |
| ⬜ | GitHub Actions deploy workflow | | Skeleton in `.github/workflows/deploy.yml` |
| ⬜ | Run migrations on production | | |
| ⬜ | Seed / import production content | | |
| ⬜ | SSL + domain DNS | | |
| ⬜ | Post-deploy smoke tests | | |
| ⬜ | Deployment runbook (README) | | See `docs/HOSTING.md` |

**Phase 9 progress:** 0 / 7

---

## Nice-to-Have (Post v1)

| Status | Feature |
|--------|---------|
| ⏭️ | Dark mode |
| ⏭️ | Hospital ratings |
| ⏭️ | Health tips blog |
| ⏭️ | Testimonials |
| ⏭️ | Video gallery |
| ⏭️ | Interactive infographics |
| ⏭️ | Live chat |
| ⏭️ | Multilingual support |

---

## Open Decisions

| # | Question | Decision | Date |
|---|----------|----------|------|
| 1 | Production domain & hosting provider | cPanel shared hosting, no SSH; FTP deploy via GitHub Actions | 2026-06-29 |
| 2 | External portal URLs | enrollments.plaschema.app, beneficiary-lookup, pay/informal, support.plaschema.app | 2026-06-29 |
| 3 | Content ownership | User supplies copy, images, organogram, seed data | 2026-06-29 |
| 4 | AI v1 | Keyword/FAQ only (no LLM API at launch) | 2026-06-29 |
| 5 | Animation library | Motion (works with Blade/Alpine; lighter than Framer Motion) | 2026-06-29 |
| 6 | Newsletter provider | Store emails locally | 2026-06-29 |
| 7 | Contact form email | cPanel SMTP | 2026-06-29 |
| 8 | Legal pages | No Privacy/Terms/Accessibility pages for v1 | 2026-06-29 |

---

## Changelog

| Date | Update |
|------|--------|
| 2026-06-29 | Created progress tracker from PRD v1.0 |
| 2026-06-29 | Phase 3 complete — provider directory, map view, admin CRUD |
| 2026-07-26 | Phase 4 started — admin authentication + role-based access complete |
| 2026-07-26 | Phase 4 complete — all 12 Admin/CMS modules delivered; 51 tests / 163 assertions pass; production build succeeds |
| 2026-07-26 | Phase 6 complete — AI Assistant MVP with deterministic intent matching, curated responses, FAQ scoring, and privacy-first disclosure; 58 tests / 192 assertions pass |
| 2026-07-26 | Phase 7 complete — 34-route API v1, Sanctum token auth, role-gated CMS endpoints, OpenAPI 3.1 docs; 66 tests / 238 assertions pass; Composer audit clean |

---

## Quick Summary

| Phase | Done | Total | % |
|-------|------|-------|---|
| 0 — Foundation | 8 | 8 | 100% |
| 1 — Design System | 9 | 9 | 100% |
| 2 — Public Pages | 24 | 24 | 100% |
| 3 — Providers | 7 | 7 | 100% |
| 4 — Admin CMS | 12 | 12 | 100% |
| 5 — Digital Services | 6 | 6 | 100% |
| 6 — AI Assistant | 6 | 6 | 100% |
| 7 — API | 6 | 6 | 100% |
| 8 — QA & A11y | 0 | 8 | 0% |
| 9 — Deployment | 0 | 7 | 0% |
| **Total** | **78** | **93** | **84%** |
