# PLASCHEMA Website — Progress Tracker

> Update this file as tasks are completed.  
> Plan reference: [IMPLEMENTATION_PLAN.md](./IMPLEMENTATION_PLAN.md)  
> Last updated: 2026-06-29

**Overall status:** Phase 1 complete  
**Current phase:** Phase 2 — Public Pages  
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
| ⬜ | Hero section (image, headline, 4 CTAs) | | |
| ⬜ | Health Plans teaser section | | |
| ⬜ | Statistics section (ApexCharts) | | |
| ⬜ | Why Choose PLASCHEMA section | | |
| ⬜ | Success Stories section | | |
| ⬜ | News preview section | | |
| ⬜ | FAQs preview section | | |
| ⬜ | Bottom call-to-action section | | |

### About
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Mission, Vision, Objectives | | |
| ⬜ | Director General profile | | |
| ⬜ | Organogram | | |
| ⬜ | History section | | |
| ⬜ | Photo gallery (LightGallery) | | |

### Health Insurance Plans
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Plan pricing cards (5 plan types) | | |
| ⬜ | Benefits comparison table | | |
| ⬜ | Mobile-responsive table scroll | | |

### News
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | News listing with categories | | |
| ⬜ | Article detail page | | |
| ⬜ | Pagination | | |

### Downloads (Resources)
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Categorized download listing | | |
| ⬜ | File download action | | |

### FAQs
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Category grouping | | |
| ⬜ | Search functionality | | |
| ⬜ | Accordion UI | | |

### Contact
| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Google Map embed | | |
| ⬜ | Contact form + validation | | |
| ⬜ | Office info, hotlines, email, social | | |

**Phase 2 progress:** 0 / 24

---

## Phase 3 — Provider Directory

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | `healthcare_providers` migration + model | | |
| ⬜ | Provider search page with filters | | |
| ⬜ | List view | | |
| ⬜ | Map view (Google Maps API) | | |
| ⬜ | Provider detail page | | |
| ⬜ | Seed data (≥10 providers) | | |
| ⬜ | Admin CRUD for providers | | |

**Phase 3 progress:** 0 / 7

---

## Phase 4 — Admin / CMS

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Admin authentication (Sanctum / web guard) | | |
| ⬜ | Role-based access (admin, editor) | | |
| ⬜ | Dashboard with summary stats | | |
| ⬜ | Manage pages (About content) | | |
| ⬜ | Manage health plans | | |
| ⬜ | Manage news articles (Tiptap) | | |
| ⬜ | Manage downloads (FilePond) | | |
| ⬜ | Manage FAQs | | |
| ⬜ | Manage home settings (hero, stats) | | |
| ⬜ | Contact message inbox | | |
| ⬜ | User management (admin only) | | |
| ⬜ | Grid.js data tables in admin | | |

**Phase 4 progress:** 0 / 12

---

## Phase 5 — Digital Services Hub

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Services page / home section with interactive cards | | |
| ⬜ | Online Enrollment link (configurable) | | URLs in `config/plaschema.php` |
| ⬜ | Membership Verification link | | |
| ⬜ | Premium Payment link | | |
| ⬜ | PLASCHEMA Support link | | |
| ⬜ | Admin/config for external URLs | | Env-based for now |

**Phase 5 progress:** 0 / 6

---

## Phase 6 — AI Assistant

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | Floating chat button UI | | |
| ⬜ | Chat panel (Alpine.js) | | |
| ⬜ | Enrollment guide responses | | |
| ⬜ | Find hospitals helper (link to search) | | |
| ⬜ | Plan explanation responses | | |
| ⬜ | FAQ keyword matching | | Keyword/FAQ only (no LLM v1) |
| ⏭️ | LLM integration (v2) | | Post-launch |

**Phase 6 progress:** 0 / 6 (v1 scope)

---

## Phase 7 — API Layer

| Status | Task | Owner | Notes |
|--------|------|-------|-------|
| ⬜ | API v1 route structure | | |
| ⬜ | Public read endpoints (plans, providers, news, faqs) | | |
| ⬜ | Provider search endpoint | | |
| ⬜ | Contact form endpoint | | |
| ⬜ | Sanctum-protected admin API | | |
| ⬜ | API documentation | | |

**Phase 7 progress:** 0 / 6

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
| 2026-06-29 | Phase 1 complete — layouts, nav, footer, components, admin shell |

---

## Quick Summary

| Phase | Done | Total | % |
|-------|------|-------|---|
| 0 — Foundation | 8 | 8 | 100% |
| 1 — Design System | 9 | 9 | 100% |
| 2 — Public Pages | 0 | 24 | 0% |
| 3 — Providers | 0 | 7 | 0% |
| 4 — Admin CMS | 0 | 12 | 0% |
| 5 — Digital Services | 0 | 6 | 0% |
| 6 — AI Assistant | 0 | 6 | 0% |
| 7 — API | 0 | 6 | 0% |
| 8 — QA & A11y | 0 | 8 | 0% |
| 9 — Deployment | 0 | 7 | 0% |
| **Total** | **17** | **93** | **18%** |
