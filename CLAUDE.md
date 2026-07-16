# CLAUDE.md — LDK Syahid Web App

Context file for Claude Code. Read this before making any changes.

---

## Project Overview

**LDK Syahid Web App** is a full-stack Laravel CMS + public website for Lembaga Dakwah Kampus (LDK) Syahid, UIN Jakarta. It handles public content (articles, events, news), organizational services (crowdfunding, digital library, forms), and an admin panel with role-based access.

- **Production URL**: https://ldksyah.id / https://www.ldksyah.id
- **Current version**: v2.3.0
- **PHP runtime**: 8.2+ (server) — NOTE: PHP CLI on dev machine is 5.6, do NOT run `php artisan` via CLI
- **Framework**: Laravel 8.x with Blade templating
- **Database**: MySQL

---

## Tech Stack

| Layer | Tech |
|---|---|
| Backend | Laravel 8.x, PHP 8.2+ |
| Frontend | Blade, Bootstrap 5, vanilla JS |
| Auth | Laravel UI + Sanctum + Socialite (Google OAuth) |
| Permissions | spatie/laravel-permission |
| Payment | BisaTopup/Bisabiller (QRIS), Xendit (legacy) |
| 2FA | pragmarx/google2fa (TOTP) |
| File Storage | Google Drive (flysystem-google-drive-ext) |
| Email | Brevo SMTP relay (with daily quota guard) |
| WhatsApp | Fonnte API |
| PDF | barryvdh/laravel-dompdf |
| GeoIP | geoip2/geoip2 |
| reCAPTCHA | Google Cloud reCAPTCHA Enterprise (score-based v3) |

---

## Roles & Access

| Role | Access |
|---|---|
| `Superadmin` | Full access including withdrawal execution, user management, 2FA setup |
| `HelperAdmin` | General admin panel access |
| `HelperCelsyahid` | Celengan Syahid: view/edit campaigns, donations, audit log (no withdrawal execute) |
| `HelperEventMart` | Event management |
| `HelperSPAM` | Short URL and messaging |
| `HelperMedia` | Media/content management |
| `HelperLetter` | Letter/document management |

---

## Key Directories

```
app/
  Http/Controllers/
    CelenganSyahid/Admin/   ← Celengan Syahid admin controllers
    CelenganSyahid/         ← Public donation flow (PublicController)
    Auth/                   ← Authentication
    Admin/                  ← General admin controllers
  Models/
    Campaign.php            ← Crowdfunding campaign (guarded=[])
    Donation.php            ← Donation records
    Withdrawal.php          ← Disbursement/withdrawal records (UUID PK)
    CelsyahidAuditLog.php   ← Audit trail for financial operations
  Services/
    BisaTopup.php           ← Bisabiller API client (QRIS + disbursement)
    Fonnte.php              ← WhatsApp notifications
    GoogleDrive.php         ← File storage
  Helpers/
    TwoFaHelper.php         ← TOTP 2FA verification with rate limiting
  Middleware/
    VerifyBisabillerIp.php  ← IP allowlist for callback endpoints
    SecurityHeaders.php
    ForceHttps.php
    TrackVisitor.php

resources/views/
  admin-page/               ← All admin panel views
    service/celengan-syahid/
      withdrawal/           ← Withdrawal flow views
      campaign/finance.blade.php
      dashboard/index.blade.php
    security/two-factor/    ← 2FA setup views
    forms/                  ← Dynamic form builder views
  landing-page/             ← Public website views
    service/celengan-syahid/
      payment-status.blade.php
      donation-form.blade.php

config/
  services.php              ← All third-party service config (BisaTopup, 2FA, reCAPTCHA, Brevo)
```

---

## Celengan Syahid — Financial Flow

The most security-critical part of the app. Money moves through this path:

```
Donor pays via QRIS (BisaTopup)
  → Callback hits /celengan-syahid/callback
  → Donation marked PAID
  → Balance credited to campaign

Admin initiates withdrawal:
  1. GET  /admin/celengan-syahid/withdrawal/create     (Superadmin only)
  2. POST /admin/celengan-syahid/withdrawal/inquiry    (verify bank account)
  3. POST /admin/celengan-syahid/withdrawal            (save DRAFT)
  4. GET  /admin/celengan-syahid/withdrawal/{id}/confirm
  5. POST /admin/celengan-syahid/withdrawal/{id}/execute  (2FA required)
     → Atomic DRAFT→PENDING flip before Bisabiller API call
     → Balance re-checked post-flip, rolled back to DRAFT if insufficient
  6. Bisabiller callback → /celengan-syahid/disbursement-callback/{secret}
     → Withdrawal marked COMPLETED or FAILED
```

### Withdrawal Status Flow
`DRAFT` → `PENDING` (atomic, before API call) → `COMPLETED` / `FAILED`

### Balance Calculation (`Campaign::getBalanceSummary()`)
- `qris_paid` = sum of PAID BisaTopup donations (after MDR deduction via CEIL)
- `available` = `qris_paid` − `total_withdrawn` (COMPLETED) − `pending_withdrawal` (PENDING)
- Settlement window: 15 min (`BISATOPUP_SETTLEMENT_MINUTES`) — recent PAID donations excluded from available if wallet gap exists

---

## Security Architecture

### Callback Endpoints
Both public POST endpoints are protected in layers:

| Endpoint | Protection |
|---|---|
| `/celengan-syahid/callback` | IP allowlist + throttle 120/min + signature verification (sha256) always enforced on live |
| `/celengan-syahid/disbursement-callback/{secret}` | IP allowlist + throttle 60/min + URL path secret |

**Bisabiller known IPs**: `149.28.148.247` (callback), `139.162.4.95` (test button)
**URL secret**: set `BISATOPUP_CALLBACK_DISBURSEMENT_SECRET` in `.env` and register in Bisabiller dashboard.

### 2FA for Withdrawal
- Only users in `TWO_FA_ALLOWED_USERS` env var AND with `Superadmin` role can execute withdrawals
- `TwoFaHelper::verify()` uses `verifyKeyNewer` (anti-replay), 5-attempt rate limit per user
- 2FA code required on every execute — not cached

### Race Condition Prevention
`WithdrawalController::execute()` atomically flips status DRAFT→PENDING via single `WHERE status=DRAFT UPDATE` before calling Bisabiller. If 0 rows updated, another request already won.

---

## View Patterns

### Admin Pages
Every admin page follows this component structure:
```
[page]/index.blade.php          ← extends admin body, includes components
[page]/components/
  _index-styles.blade.php       ← page-specific CSS in @section('styles')
  _index-scripts.blade.php      ← page-specific JS in @section('scripts')
```

### CSS Class Conventions (Admin Celengan Syahid)
- `.page-title` + `.highlighted-text` — page heading (color `#00a79d`)
- `.section-title` — card section header with bottom border
- `.btn-custom-primary` — primary action button (brand teal `#00a79d`)
- `.card.border-0.shadow-sm` — standard section card
- `.form-label.fw-bold` + `.form-control-plaintext` — read-only field pair

### Dark Mode
The app supports dark mode via `[data-theme="dark"]` attribute on `<html>`. Always include dark mode overrides when adding new CSS.

---

## Environment Variables (Key ones)

```env
# BisaTopup / Bisabiller
BISATOPUP_USERNAME=
BISATOPUP_PASSWORD_API=
BISATOPUP_ENV=live                  # 'dev' | 'live'
BISATOPUP_ENFORCE_CALLBACK_SIGNATURE=false   # ignored on live (always enforced)
BISATOPUP_CALLBACK_DISBURSEMENT_SECRET=      # path secret for disbursement callback URL
BISATOPUP_ALLOWED_IPS=149.28.148.247,139.162.4.95
BISATOPUP_QRIS_MDR_PERCENT=1
BISATOPUP_SETTLEMENT_MINUTES=15

# 2FA
TWO_FA_ALLOWED_USERS=email1@example.com,email2@example.com
TWO_FA_APP_NAME=LDK Syahid Admin
TWO_FA_DISCREPANCY_THRESHOLD=50000  # Rp tolerance for balance report

# reCAPTCHA
RECAPTCHA_ENABLED=true
RECAPTCHA_TYPE=score                # 'score' (v3) | 'checkbox' (v2)

# Email
MAIL_MAILER=brevo
BREVO_API_KEY=
```

---

## Scheduled Commands

| Command | Schedule | Purpose |
|---|---|---|
| `AggregateVisitorStats` | Daily | Roll up raw visitor logs into daily stats |
| `CleanupVisitorLogs` | Daily | Prune old raw visitor log records |
| `CloseExpiredForms` | Hourly | Close published forms past end date |
| `ExpireStaleQrisDonations` | Every 15 min | Auto-expire QRIS records past Bisabiller expiry |

---

## Working on This Project

### Do NOT
- Run `php artisan` via terminal — PHP CLI is 5.6, it will fail silently or error
- Use `DB::statement()` or raw queries with unparameterized user input
- Use `{!! !!}` for user-supplied content in public views (XSS risk)
- Add `Log::debug()` for routine operations in production — only use for errors
- Expose exception messages (`$e->getMessage()`) directly to HTTP responses

### Do
- Follow the existing component file pattern (separate `_styles` and `_scripts` blade includes)
- Use `hash_equals()` for any secret/token comparison (timing-safe)
- Add `CelsyahidAuditLog::record()` for any financial state changes
- Include dark mode CSS overrides (`[data-theme="dark"]`) for new UI elements
- Validate URLs before rendering in `href` attributes (check `https://` scheme)
- Use `Withdrawal::where('id', $id)->where('status', 'DRAFT')->update(...)` pattern for atomic state transitions

### Testing Withdrawals (Dev)
1. Switch Bisabiller dashboard to DEV environment
2. Set `BISATOPUP_ENV=dev` in `.env`
3. Use sandbox API credentials
4. Callback URL in Bisabiller dashboard must include the secret path segment

---

## Audit Log

Every financial operation in Celengan Syahid must be logged:

```php
CelsyahidAuditLog::record(
    'withdrawal.executed',   // action
    'withdrawal',            // entity_type
    $withdrawal->id,         // entity_id
    'Description...'        // description
);
```

Common actions: `withdrawal.draft`, `withdrawal.executed`, `withdrawal.failed`, `withdrawal.balance_check_failed`, `2fa.verify_success`, `2fa.verify_failed`, `donation.create`, `donation.update`, `donation.delete`, `campaign.create`, `campaign.update`

---

## Balance Report Logic

The Balance Report (`/admin/celengan-syahid/balance-report`) compares:
- **Actual balance**: live from Bisabiller API (`GET /api/account-info`)
- **Expected balance**: `allPaidCredit − COMPLETED_withdrawals − PENDING_withdrawals`

MDR formula: `CEIL(gross × mdrRate)` — matches Bisabiller's own per-transaction CEIL rounding.

Settlement detection: if `actualBalance < expectedAll`, attribute the gap to the most recent PAID donations (sorted newest-first) within the settlement window. Only mark those as "Settling..." until the gap is fully attributed.
