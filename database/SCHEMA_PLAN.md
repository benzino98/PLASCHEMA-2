# Database Schema Plan

> Phase 0 planning document. Migrations will be implemented in Phases 3–4.

## Overview

MySQL database for PLASCHEMA public site content and admin CMS. Local dev uses `plaschema` database (see `.env.example`).

---

## Entities

### `users`
Staff accounts for admin CMS.

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name | string | |
| email | string unique | |
| password | string | |
| role | enum | `admin`, `editor` |
| email_verified_at | timestamp nullable | |
| remember_token | string nullable | |
| timestamps | | |

---

### `faq_categories` / `faqs`

**faq_categories:** `id`, `name`, `slug`, `sort_order`, `timestamps`

**faqs:** `id`, `faq_category_id` FK, `question`, `answer` (text), `sort_order`, `is_published`, `timestamps`

---

### `health_plans` / `plan_benefits`

**health_plans:** `id`, `name`, `slug`, `sector` (formal/informal/family/student/vulnerable), `description`, `price_label`, `price_amount` (decimal nullable), `is_featured`, `sort_order`, `timestamps`

**plan_benefits:** `id`, `health_plan_id` FK, `benefit_key`, `benefit_label`, `is_included` (boolean), `sort_order`

---

### `healthcare_providers`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name | string | |
| slug | string unique | |
| lga | string | Local Government Area |
| specialty | string nullable | |
| ownership | string nullable | public/private/etc |
| services | json nullable | array of service names |
| address | text | |
| phone | string nullable | |
| email | string nullable | |
| working_hours | text nullable | |
| latitude | decimal(10,8) nullable | |
| longitude | decimal(11,8) nullable | |
| accreditation_status | string | accredited/pending/suspended |
| is_published | boolean | default true |
| timestamps | | |

**healthcare_provider_photos:** `id`, `healthcare_provider_id` FK, `path`, `caption`, `sort_order`

---

### `news_articles`

`id`, `title`, `slug`, `excerpt`, `body` (longtext), `category` (article/campaign/activity/press), `featured_image` nullable, `published_at` nullable, `is_published`, `timestamps`

---

### `downloads`

`id`, `title`, `slug`, `category` (form/policy/guideline/report/circular), `description` nullable, `file_path`, `file_size`, `mime_type`, `published_at`, `is_published`, `timestamps`

---

### `pages` / `page_sections`

**pages:** `id`, `slug` (about, home, contact), `title`, `meta_description` nullable, `timestamps`

**page_sections:** `id`, `page_id` FK, `key` (mission, vision, dg_profile, etc.), `title` nullable, `content` (longtext/json), `sort_order`, `timestamps`

---

### `contact_messages`

`id`, `name`, `email`, `subject`, `message` (text), `is_read`, `read_at` nullable, `timestamps`

---

### `newsletter_subscribers`

`id`, `email` unique, `subscribed_at`, `unsubscribed_at` nullable, `timestamps`

> Stored locally per project decision (no Mailchimp/Brevo v1).

---

### `site_settings`

Key-value store for hero text, statistics, social links, emergency numbers.

`id`, `group` (home, contact, social), `key`, `value` (text/json), `timestamps`

Unique index on `(group, key)`.

---

### `success_stories` (optional v1)

`id`, `title`, `excerpt`, `body`, `image` nullable, `sort_order`, `is_published`, `timestamps`

---

## Migration Order

1. users (Laravel default + role column)
2. faq_categories → faqs
3. health_plans → plan_benefits
4. healthcare_providers → healthcare_provider_photos
5. news_articles
6. downloads
7. pages → page_sections
8. contact_messages
9. newsletter_subscribers
10. site_settings
11. success_stories (optional)

---

## Indexes

- `healthcare_providers`: index on `lga`, `specialty`, `accreditation_status`, `slug`
- `news_articles`: index on `category`, `published_at`, `slug`
- `downloads`: index on `category`, `slug`
- `faqs`: index on `faq_category_id`

---

## Notes

- SQLite is used only for default Laravel install smoke tests; production and local dev target **MySQL**.
- Sanctum personal access tokens table added when API auth is implemented (Phase 7).
- File uploads stored on `storage/app/public` with symlinks per Laravel convention.
