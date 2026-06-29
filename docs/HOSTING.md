# Shared Hosting Deployment Guide

> PLASCHEMA production deployment on **cPanel shared hosting** (no SSH).  
> Deploy via **FTP** using GitHub Actions.

---

## Hosting Requirements

| Requirement | Minimum |
|-------------|---------|
| PHP | 8.3+ (8.4 recommended) |
| Extensions | `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo` |
| MySQL | 5.7+ or MariaDB 10.3+ |
| Document root | Must point to Laravel `public/` directory |
| SSL | Required (Let's Encrypt via cPanel) |
| Cron | Required for Laravel scheduler |
| Composer | Not required on server (vendor deployed from CI) |
| Node.js | Not required on server (assets built in CI) |

---

## cPanel Setup Checklist

### 1. Domain & document root
- Add domain or subdomain in cPanel
- Set document root to `public_html/public` (or symlink strategy below)
- Enable AutoSSL / Let's Encrypt

### 2. MySQL database
- Create database: e.g. `cpaneluser_plaschema`
- Create database user with full privileges
- Note host (usually `localhost`), database name, username, password

### 3. FTP account
- Create FTP user with access to site root
- Note: hostname, username, password, remote path (e.g. `/public_html`)

### 4. Email (contact form)
- Create mailbox in cPanel for `info@plaschema.gov.ng` (or chosen address)
- Use cPanel SMTP credentials in production `.env`:
  - `MAIL_MAILER=smtp`
  - `MAIL_HOST=mail.yourdomain.com`
  - `MAIL_PORT=587` (or 465 SSL)
  - `MAIL_USERNAME=` full email address
  - `MAIL_PASSWORD=` mailbox password
  - `MAIL_ENCRYPTION=tls`

### 5. Cron job
Add in cPanel → Cron Jobs (every minute):

```bash
* * * * * /usr/local/bin/php /home/CPANEL_USER/public_html/artisan schedule:run >> /dev/null 2>&1
```

Adjust PHP path and project path per host documentation.

### 6. Storage symlink
Without SSH, options:
- **Option A:** Deploy script creates symlink via cPanel File Manager (manual once)
- **Option B:** Use cPanel "Terminal" if available: `php artisan storage:link`
- **Option C:** Copy `storage/app/public` contents to `public/storage` on each deploy (CI script)

---

## Directory Layout on Server

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← document root
│   ├── index.php
│   ├── build/       ← Vite compiled assets
│   └── storage/     ← symlink to ../storage/app/public
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env             ← production secrets (NOT in git)
└── artisan
```

**Important:** The web root must be `public/`, not the project root.

---

## GitHub Actions Secrets

Configure in repository → Settings → Secrets:

| Secret | Description |
|--------|-------------|
| `FTP_SERVER` | FTP hostname |
| `FTP_USERNAME` | FTP username |
| `FTP_PASSWORD` | FTP password |
| `FTP_SERVER_DIR` | Remote directory (e.g. `/public_html/`) |

Production `.env` is managed manually on server or via a secure secret deploy step (not committed to git).

---

## Production `.env` Essentials

```env
APP_NAME=PLASCHEMA
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.plaschema.gov.ng

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=cpaneluser_plaschema
DB_USERNAME=cpaneluser_dbuser
DB_PASSWORD=***

PLASCHEMA_ENROLLMENT_URL=https://enrollments.plaschema.app
PLASCHEMA_VERIFICATION_URL=https://enrollments.plaschema.app/beneficiary-lookup
PLASCHEMA_PAYMENT_URL=https://enrollments.plaschema.app/pay/informal
PLASCHEMA_SUPPORT_URL=https://support.plaschema.app/support

GOOGLE_MAPS_API_KEY=***

MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=info@plaschema.gov.ng
MAIL_PASSWORD=***
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@plaschema.gov.ng
MAIL_FROM_NAME=PLASCHEMA
```

---

## Post-Deploy Commands

Run once after first deploy (via cPanel Terminal if available, or manual DB import):

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

Without shell access, run migrations locally against production DB (temporary IP whitelist) or use cPanel phpMyAdmin for initial schema import.

---

## FTP Deploy Notes

- CI builds assets (`npm run build`) before upload
- Exclude from upload: `.git`, `node_modules`, `tests`, `.github`
- Include: `vendor/` (from `composer install --no-dev` in CI)
- Set folder permissions: `storage/` and `bootstrap/cache/` writable (755 or 775 per host)

---

## Troubleshooting

| Issue | Fix |
|-------|-----|
| 500 error | Check `storage/logs/laravel.log`; verify `.env` exists |
| CSS/JS missing | Ensure `public/build/` uploaded; run `npm run build` in CI |
| Mixed content | Force HTTPS in `.env` `APP_URL` |
| Contact form fails | Verify cPanel SMTP credentials |
| Maps not loading | Check `GOOGLE_MAPS_API_KEY` and API restrictions |
