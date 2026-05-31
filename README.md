# LDK Syahid Web App

<div align="center" style='text-align : center;'>
  <div class="row">
  <img src="https://laravel.com/img/logomark.min.svg" width="100px">
  </div>
  <br>
  <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="ldk-logo" width="250px"/>
  <br>
  <i>#KitaAdalahSaudara</i>
  <br>
</div>

<br>
<div align="center">
<img src="https://img.shields.io/badge/version-v2.0.3-blue" />
<img src="https://img.shields.io/badge/laravel-8.x-red" />
<img src="https://img.shields.io/badge/php-%3E%3D7.4-777BB4" />
<img src="https://img.shields.io/badge/license-LDK Syahid-green" />
<img src="https://img.shields.io/badge/contributors-11-brightgreen" />
</div>

## About

LDK Syahid Web App is a comprehensive web platform for **Lembaga Dakwah Kampus (LDK) Syahid UIN Jakarta**. It serves as both a public-facing website and a role-based admin panel (CMS) for managing organizational content, services, and member activities.

## Features

### Public Website
- **Landing Page** — Hero jumbotron banners, testimonies, articles, events, and schedules
- **Articles & News** — Content publishing with comment system
- **Events** — Event listing and detail pages
- **Gallery** — Photo gallery of organizational activities
- **Organization Structure** — Interactive org chart display
- **EKSPRESI** — Creative expression section

### Services
- **Celengan Syahid** — Crowdfunding donation platform with Xendit payment gateway and WhatsApp notifications via Fonnte
- **Dynamic Forms** — Visual form builder with multiple field types (text, email, number, dropdown, radio, checkbox, file upload, rating, linear scale, etc.) and lifecycle management (draft → published → closed → archived)
- **Short URL** — URL shortener with public request and admin approval workflow
- **KTA LDK Syahid** — Digital member ID card (Kartu Tanda Anggota) generation
- **Zakat Calculator** — Zakat calculation with real-time Antam gold price
- **Kalkulator Kestari** — Program work calculator
- **Call Kestari** — Service request portal
- **IT Support** — IT support ticket system
- **Digital Library** — Book catalog with in-browser PDF reader

### Admin Panel (CMS)
- **Dashboard** — Visitor analytics, quick stats, and motivational quotes
- **Content Management** — Full CRUD for jumbotrons, articles, news, events, schedules, gallery, structure, and testimonies
- **Service Management** — Manage Celengan Syahid campaigns & donations, shortlinks, Call Kestari, KTA, catalog books, and finance reports
- **Dynamic Form Builder** — Visual drag-and-drop form builder with field reordering, section management, and Google Sheets integration
- **User Management** — User CRUD with role assignment, search, and filter (Superadmin only)
- **Email System** — Compose and send custom emails, newsletter management
- **Job Queue Monitor** — View, retry, and manage queued/failed jobs
- **App Settings** — Global key-value configuration (Superadmin only)

### Authentication & Authorization
- Standard registration and login with email verification
- Google OAuth login via Laravel Socialite
- API authentication via Laravel Sanctum
- Role-based access control (RBAC) using Spatie Laravel Permission with 7 roles: `Superadmin`, `HelperAdmin`, `HelperCelsyahid`, `HelperEventMart`, `HelperSPAM`, `HelperMedia`, `HelperLetter`

### Analytics & Monitoring
- Per-request visitor tracking (IP, device, OS, browser, GeoIP country, page)
- Daily unique visitor aggregation
- Page view statistics
- Scheduled cleanup of old visitor logs

## Tech Stack

| Layer | Technology |
| --- | --- |
| Framework | Laravel 8.x |
| Language | PHP >= 7.4 |
| Database | MySQL |
| Frontend | Blade, Bootstrap 5, SASS, Laravel Mix |
| Auth | Laravel UI + Sanctum + Socialite (Google OAuth) |
| Permissions | spatie/laravel-permission |
| File Storage | Google Drive (flysystem-google-drive-ext) |
| Payment | Xendit |
| WhatsApp API | Fonnte |
| PDF Generation | barryvdh/laravel-dompdf |
| DataTables | yajra/laravel-datatables |
| Short URLs | ashallendesign/short-url |
| GeoIP | geoip2/geoip2 |
| Device Detection | jenssegers/agent |
| Indonesia Region Data | laravolt/indonesia |
| Avatar | laravolt/avatar |
| reCAPTCHA | biscolab/laravel-recaptcha |
| Alerts | realrashid/sweet-alert |

## System Requirements

| Requirement | Version |
| --- | --- |
| OS | Windows or Unix-based |
| PHP | >= 7.4 |
| XAMPP | >= 3.3.0 |
| Composer | >= 2.x |
| Laravel | 8.x |
| Node.js | >= 8.15.0 |
| Git | >= 2.33.1 |

## Development Setup

### Prerequisites

<ul>
    <li><a href="https://code.visualstudio.com/download" target="_blank" rel="noopener noreferrer">Visual Studio Code</a></li>
    <li><a href="https://windows.php.net/download#php-7.4" target="_blank" rel="noopener noreferrer">PHP 7.4</a></li>
    <li><a href="https://www.apachefriends.org/download.html" target="_blank" rel="noopener noreferrer">XAMPP</a></li>
    <li><a href="https://getcomposer.org/download/" target="_blank" rel="noopener noreferrer">Composer</a></li>
    <li><a href="https://nodejs.org/en/download" target="_blank" rel="noopener noreferrer">Node JS</a></li>
    <li><a href="https://git-scm.com/downloads" target="_blank" rel="noopener noreferrer">Git</a></li>
</ul>

### Installation

**1. Clone the project**

```bash
git clone https://github.com/ldksyahid/ldksyahid-app.git
cd ldksyahid-app
```

**2. Create Database**

Run Apache and MySQL in XAMPP, then open PHPMyAdmin to create database `ldksyahid_db` and import from <a href="https://drive.google.com/drive/folders/1EWyRlyuJNta8OeegRDapp_optXfPEPG_?usp=sharing" target="_blank" rel="noopener noreferrer">latest database</a>

**3. Vendor**

Remove previous folder vendor and Download <a href="https://drive.google.com/drive/folders/1_tSANdG2LfgsoUkwKqbhRD-7jyAEsuvv?usp=sharing" target="_blank" rel="noopener noreferrer">lates vendor</a> and then exctract file into folder directory `ldksyahid-app/`

**4. Node Modules**

```bash
npm install
```

**5. Environment Configuration**

<ol>
    <li>Copy paste ".env.example" and rename to ".env"</li>
    <li>Change all code .env from latest .env by <a href="https://wa.me/62895394755672" target="_blank" rel="noopener noreferrer">Contact Me</a> to get latest .env</li>
</ol>

**6. Generate Application Key**

```bash
php artisan key:generate
```

**7. Run the Project**

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Default Login

| Field | Value |
| --- | --- |
| Email | admin@ldksyah.id |
| Password | admin |

## Project Structure

```
ldksyahid-app/
├── app/
│   ├── Console/Commands/        # Scheduled artisan commands
│   ├── Constants/               # App-wide setting key constants
│   ├── Helpers/                 # GeoIpHelper, DatacenterDetector
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin panel controllers
│   │   │   ├── API/             # API controllers
│   │   │   └── Auth/            # Authentication controllers
│   │   └── Middleware/          # TrackVisitor, SecurityHeaders, ForceHttps, NoCacheAjax
│   ├── Jobs/                    # Queued mail & cleanup jobs
│   ├── Mail/                    # Mailable classes
│   ├── Models/
│   │   └── forms/               # Dynamic form models
│   ├── Notifications/           # Email verification, password reset
│   ├── Services/                # External service wrappers
│   └── Traits/                  # UsesUuid
├── database/
│   └── migrations/              # 50+ database migrations
├── resources/
│   └── views/
│       ├── admin-page/          # Admin panel views
│       ├── landing-page/        # Public website views
│       ├── emails/              # Email templates
│       └── components/          # Reusable Blade components
├── routes/
│   ├── web.php                  # Web routes
│   └── api.php                  # API routes (Sanctum)
├── public/                      # Public assets
├── config/                      # Configuration files
└── storage/                     # Logs, cache, uploads
```

## API Endpoints

Authenticated via Laravel Sanctum (`/api` prefix):

| Method | Endpoint | Description |
| --- | --- | --- |
| POST | `/api/login` | Get API token |
| GET | `/api/user` | Authenticated user info |
| GET/POST/PUT/DELETE | `/api/testimony` | Testimony CRUD |
| GET/POST/PUT/DELETE | `/api/news` | News CRUD |

## Scheduled Commands

| Command | Description |
| --- | --- |
| `AggregateVisitorStats` | Rolls up visitor logs into daily unique/page stat tables |
| `CleanupVisitorLogs` | Prunes old raw visitor logs |
| `CloseExpiredForms` | Closes published forms past their end date |
| `RunDonationClassMachine` | Processes donation state machine transitions |

## Version History

| Version | Date | Changes |
| :---: | :---: | --- |
| `2.0.3` | `2026-05-31` | <ul><li>Fix Brevo silent email drop — check daily quota via Brevo REST API before sending so emails are not silently discarded when the free-plan 300/day limit is hit</li><li>Jobs hold until midnight UTC (Brevo reset time) and resume automatically</li><li>Fix TrackVisitor race condition — replace non-atomic check-then-insert with `insertOrIgnore` to eliminate duplicate-key errors under concurrent requests</li></ul> |
| `2.0.2` | `2026-05-31` | <ul><li>Add Estimated Completion card to Job Queue Log — shows projected finish date/time based on pending jobs, rate limit (10/min), and Brevo daily quota (300/day)</li><li>Fix queue worker schedule for shared hosting with 10-minute cron minimum (`--max-time=540` instead of `--stop-when-empty`)</li><li>Rename daily-limit banner from Gmail to generic mail relay wording</li></ul> |
| `2.0.1` | `2026-05-30` | <ul><li>Migrate job-based email from Gmail SMTP to Brevo SMTP relay with deliverability validation (MX/DNS check)</li><li>Add daily sending limit hold mechanism — jobs are held and resume automatically when quota resets</li><li>Fix Pause state persistence in Job Queue Log monitor (survives page refresh)</li><li>Fix mobile share sheet (Salin URL & WhatsApp) producing relative paths instead of absolute URLs</li><li>Contact person Laporan Keuangan now dynamic via App Settings</li></ul> |
| `2.0.0` | `2026-05-28` | <ul><li>Dynamic Form Builder with visual drag-and-drop, multiple field types (rating, linear scale, etc.), and lifecycle management</li><li>Digital Library (Perpustakaan) with in-browser PDF reader</li><li>Finance Report module</li><li>Visitor analytics with GeoIP tracking, daily aggregation, and page stats</li><li>Job Queue monitoring and management in admin panel</li><li>Email generation system for custom admin emails</li><li>Newsletter subscription management</li><li>Zakat Calculator with real-time gold price API</li><li>Google Sheets integration for form submissions</li><li>Enhanced security headers and HTTPS enforcement</li><li>Revamped popup theme (Milad 30 LDK Syahid)</li></ul> |
| `1.1.0` | `2023-10-25` | <ul><li>Add KTA LDK Syahid Feature</li><li>New Mobile Responsive CMS Admin</li></ul> |
| `1.0.3` | `2023-09-28` | <ul><li>Add Ekspresi Content and Develop Celsyahid Machine Learning</li></ul> |
| `1.0.2` | `2023-07-22` | <ul><li>Update Notify Celengan Syahid</li></ul> |
| `1.0.1` | `2023-05-28` | <ul><li>Revamp Admin Form</li></ul> |
| `1.0.0` | `2022-12-22` | <ul><li>Initial Version</li></ul> |
