# Shared Hosting Deployment Guide

> PLASCHEMA production deployment on **cPanel shared hosting without SSH/Terminal access** (root directory: `/home/plaschem`).  
> Deploy via **FTP / FTPS** using GitHub Actions CI/CD.

---

## 1. Architecture Overview

To secure sensitive configuration files (`.env`, `storage`, business logic) on shared hosting where the document root is fixed to `public_html`, the application is split into two directories under `/home/plaschem`:

```
/home/plaschem/
├── plaschema/                    ← Laravel core files (OUTSIDE public_html, inaccessible from web)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   │   ├── app/
│   │   ├── framework/
│   │   └── logs/
│   ├── vendor/                   ← Built & optimized in CI
│   ├── .env                      ← Production environment secrets (manual on server)
│   └── artisan
│
└── public_html/                  ← Web root (ONLY publicly accessible assets)
    ├── index.php                 ← Loads ../plaschema/vendor/autoload.php and bootstrap/app.php
    ├── .htaccess                 ← Apache URL rewrite & security headers
    ├── robots.txt
    ├── favicon.ico
    ├── build/                    ← Vite compiled CSS & JS assets
    └── storage/                  ← Symlink to /home/plaschem/plaschema/storage/app/public
```

---

## 2. GitHub Secrets Setup

In your GitHub repository, navigate to **Settings → Secrets and variables → Actions** and add the following repository secrets:

| Secret Name | Required | Example / Description |
|---|---|---|
| `FTP_SERVER` | **Yes** | Hostname or IP of your server (e.g. `ftp.plaschema.gov.ng` or server IP) |
| `FTP_USERNAME` | **Yes** | FTP username with access to `/home/plaschem` (e.g. `plaschem`) |
| `FTP_PASSWORD` | **Yes** | Password for the FTP account |
| `FTP_SERVER_DIR` | No | `./` *(default, targets `/home/plaschem`)* |
| `FTP_PROTOCOL` | No | `ftp` *(default, or `ftps` if your host supports TLS)* |
| `APP_URL` | No | `https://www.plaschema.gov.ng` *(enables automatic post-deploy migrations)* |
| `DEPLOY_KEY` | No | A secret key matching `DEPLOY_KEY` in your `.env` |

> [!IMPORTANT]
> **cPanel FTP Account Directory Setting:**  
> When creating or verifying your FTP user in cPanel, ensure its home/root directory is set to **`/home/plaschem`** (or use your primary cPanel login account, which already defaults to `/home/plaschem`). Do not set it to `public_html`, otherwise the action cannot upload to `/home/plaschem/plaschema`.

---

## 3. Server-Side Initial Setup (cPanel)

### A. Create Production `.env`
In cPanel **File Manager** (enable "Show Hidden Files"), create `/home/plaschem/plaschema/.env`:

```env
APP_NAME=PLASCHEMA
APP_ENV=production
APP_KEY=base64:your_generated_app_key_here
APP_DEBUG=false
APP_URL=https://www.plaschema.gov.ng

# Secret key to authorize running migrations/cache without terminal
DEPLOY_KEY=choose_a_strong_random_secret_string_here

LOG_CHANNEL=daily
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plaschem_db
DB_USERNAME=plaschem_user
DB_PASSWORD=your_secure_db_password

SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database

PLASCHEMA_ENROLLMENT_URL=https://enrollments.plaschema.app
PLASCHEMA_VERIFICATION_URL=https://enrollments.plaschema.app/beneficiary-lookup
PLASCHEMA_PAYMENT_URL=https://enrollments.plaschema.app/pay/informal
PLASCHEMA_SUPPORT_URL=https://support.plaschema.app/support

GOOGLE_MAPS_API_KEY=your_google_maps_key

MAIL_MAILER=smtp
MAIL_HOST=mail.plaschema.gov.ng
MAIL_PORT=587
MAIL_USERNAME=info@plaschema.gov.ng
MAIL_PASSWORD=your_mailbox_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@plaschema.gov.ng"
MAIL_FROM_NAME="PLASCHEMA"
```

---

## 4. Running Migrations & Commands Without Terminal Access

Because you do not have SSH/Terminal access, we have built two reliable options into this project:

### Method 1: The Built-in Web Deployment Console (Recommended)
This application includes a secure web maintenance console protected by `DEPLOY_KEY`.

1. **Access the Console in Browser**:
   Open:
   ```
   https://www.plaschema.gov.ng/_deploy?key=YOUR_DEPLOY_KEY
   ```
   *(Replace with the `DEPLOY_KEY` you set in your `.env`)*.

2. **Actions Available**:
   - 🚀 **Run All Post-Deploy Tasks**: Runs migrations, links storage, and caches configurations in one click.
   - 🗄️ **Run Migrations**: Runs `php artisan migrate --force` and prints real-time terminal output.
   - 🔗 **Create Storage Link**: Automatically links `/home/plaschem/public_html/storage` to `/home/plaschem/plaschema/storage/app/public`.
   - ⚡ **Cache & Optimize**: Runs `php artisan optimize` for faster page loads in production.
   - 🧹 **Clear Cache**: Clears view, route, and config caches.

3. **Automatic Execution via CI/CD**:
   If you add `DEPLOY_KEY` and `APP_URL` to your **GitHub Secrets**, GitHub Actions will automatically call this endpoint right after files are uploaded via FTP, running migrations for you with zero manual steps!

---

### Method 2: cPanel One-Shot Cron Job (CLI Fallback)
If for any reason you prefer native CLI execution without using the web console:

1. In cPanel, navigate to **Cron Jobs**.
2. Add a new cron job scheduled to run in 1–2 minutes:
   ```bash
   /usr/local/bin/php /home/plaschem/plaschema/artisan migrate --force
   ```
3. Set your email address in the cPanel cron settings to receive the migration output.
4. **Delete or disable the cron job** once you receive the confirmation email so it does not run repeatedly.

To link storage using this method:
```bash
/usr/local/bin/php /home/plaschem/plaschema/artisan storage:link
```
Or native symlink:
```bash
ln -s /home/plaschem/plaschema/storage/app/public /home/plaschem/public_html/storage
```

---

## 5. Setting Up the Laravel Scheduler Cron Job
For scheduled tasks (cleanups, queues, digests) to run automatically:
In **cPanel → Cron Jobs**, add a recurring job that runs **every minute** (`* * * * *`):

```bash
* * * * * /usr/local/bin/php /home/plaschem/plaschema/artisan schedule:run >> /dev/null 2>&1
```

*(Note: Verify the PHP CLI path with your host, e.g. `/usr/local/bin/php`, `/usr/bin/php`, or `/usr/local/bin/ea-php83`).*

---

## 6. How to Trigger Deployments

### Manual Trigger (Default)
Automatic deployment on `git push` is currently disabled so you can safely configure your credentials.

To deploy manually:
1. Go to your GitHub repository → **Actions** tab.
2. Select **Deploy to Shared Hosting** from the left sidebar.
3. Click **Run workflow** → select branch (`main`) → click the green **Run workflow** button.

### Enabling Automatic Deploy on Push to `main`
Once your secrets are tested and verified:
1. Open `.github/workflows/deploy.yml`.
2. Uncomment the `push:` trigger at lines 7–8:
   ```yaml
   on:
     workflow_dispatch:
     push:
       branches: [main]
   ```
3. Commit and push. Every subsequent push to `main` will build and deploy automatically!
