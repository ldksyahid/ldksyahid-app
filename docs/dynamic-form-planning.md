# Dynamic Form Builder - Technical Planning Document

> **Project:** LDK Syahid App
> **Version:** 1.0
> **Tanggal:** 17 Mei 2026
> **Status:** Planning Phase
> **Author:** Development Team

---

## Daftar Isi

1. [High Level Architecture](#1-high-level-architecture)
2. [Database Design](#2-database-design)
3. [ERD Concept](#3-erd-concept)
4. [Table List](#4-table-list)
5. [Detail Column Tiap Table](#5-detail-column-tiap-table)
6. [Data Type Recommendation](#6-data-type-recommendation)
7. [Index Recommendation](#7-index-recommendation)
8. [Relationship Antar Table](#8-relationship-antar-table)
9. [Form Builder Flow](#9-form-builder-flow)
10. [Submission Flow](#10-submission-flow)
11. [Spreadsheet Result Flow](#11-spreadsheet-result-flow)
12. [Public Form Security](#12-public-form-security)
13. [File Upload Strategy](#13-file-upload-strategy)
14. [Validation Strategy](#14-validation-strategy)
15. [Scalability Strategy](#15-scalability-strategy)
16. [API Structure Recommendation](#16-api-structure-recommendation)
17. [Frontend Component Planning](#17-frontend-component-planning)
18. [Admin UI Planning](#18-admin-ui-planning)
19. [Public UI Planning](#19-public-ui-planning)
20. [Future Enhancement List](#20-future-enhancement-list)
21. [Audit Log Planning](#21-audit-log-planning)
22. [Versioning Form Strategy](#22-versioning-form-strategy)
23. [Draft & Publish Mechanism](#23-draft--publish-mechanism)
24. [Form Expired Mechanism](#24-form-expired-mechanism)
25. [Anti Spam Strategy](#25-anti-spam-strategy)
26. [Rate Limiting Strategy](#26-rate-limiting-strategy)
27. [Performance Consideration](#27-performance-consideration)
28. [Queue/Background Job Recommendation](#28-queuebackground-job-recommendation)
29. [Dynamic Schema vs JSON Strategy](#29-dynamic-schema-vs-json-strategy)
30. [Spreadsheet Architecture Recommendation](#30-spreadsheet-architecture-recommendation)
31. [Notification System Recommendation](#31-notification-system-recommendation)
32. [Access Permission Structure](#32-access-permission-structure)
33. [Recommended Folder Structure](#33-recommended-folder-structure)
34. [Naming Convention Rules](#34-naming-convention-rules)
35. [Coding Standard Recommendation](#35-coding-standard-recommendation)
36. [Migration Strategy](#36-migration-strategy)
37. [Example Dummy Data](#37-example-dummy-data)
38. [Example API Payload](#38-example-api-payload)
39. [Example JSON Structure](#39-example-json-structure)
40. [Edge Cases](#40-edge-cases)
41. [Risks & Mitigation](#41-risks--mitigation)
42. [Development Phase Recommendation](#42-development-phase-recommendation)
43. [Testing Strategy](#43-testing-strategy)
44. [QA Checklist](#44-qa-checklist)
45. [Deployment Checklist](#45-deployment-checklist)

---

## 1. High Level Architecture

### 1.1 Arsitektur Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                              │
├──────────────────────────┬──────────────────────────────────────┤
│     Admin Panel (SPA)    │         Public Form (SSR)            │
│  - Form Builder UI       │  - Dynamic Form Renderer             │
│  - Spreadsheet Viewer    │  - File Upload Handler               │
│  - Submission Manager    │  - Validation Engine                 │
│  - Analytics Dashboard   │  - Thank You Page                    │
└──────────────────────────┴──────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                      APPLICATION LAYER                           │
├─────────────────────────────────────────────────────────────────┤
│  Laravel 8.x Framework                                          │
│  ┌────────────┐ ┌──────────────┐ ┌───────────────────────────┐ │
│  │ Controllers│ │  Services    │ │     Middleware            │ │
│  │            │ │              │ │  - Auth (Sanctum)         │ │
│  │ - FormCtrl │ │ - FormSvc   │ │  - Role (Spatie)          │ │
│  │ - FieldCtrl│ │ - SubmitSvc │ │  - RateLimit              │ │
│  │ - SubmitCtrl│ │ - ExportSvc │ │  - CSRF                   │ │
│  │ - ExportCtrl│ │ - NotifSvc  │ │  - AntiSpam               │ │
│  └────────────┘ └──────────────┘ └───────────────────────────┘ │
│  ┌────────────┐ ┌──────────────┐ ┌───────────────────────────┐ │
│  │   Models   │ │    Jobs      │ │     Events/Listeners      │ │
│  │            │ │              │ │                           │ │
│  │ - MsForm   │ │ - ExportJob │ │  - FormSubmitted          │ │
│  │ - MsField  │ │ - NotifyJob │ │  - FormPublished          │ │
│  │ - TrSubmit │ │ - CleanupJob│ │  - ExportCompleted        │ │
│  └────────────┘ └──────────────┘ └───────────────────────────┘ │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                       DATA LAYER                                 │
├───────────────────────────────────────────────────────────────────┤
│    MySQL                     │         Google Drive               │
│                              │                                   │
│ - ms_form                   │  - File Uploads                   │
│ - ms_field                  │  - Image Uploads                  │
│ - tr_submit                 │  - Google Sheets (responses)      │
│ - tr_form_file / audit_log  │                                   │
└──────────────────────────────┴───────────────────────────────────┘
```

### 1.2 Design Principles

| Principle | Penjelasan |
|-----------|-----------|
| **Separation of Concerns** | Form definition, submission, dan result viewing dipisah sebagai modul independen |
| **Schema-less Storage** | Submission data disimpan sebagai JSON untuk fleksibilitas field dinamis |
| **Event-Driven** | Setiap submission trigger event untuk notification, logging, dan post-processing |
| **Progressive Enhancement** | UI berjalan tanpa JavaScript untuk accessibility, enhanced dengan JS |
| **Scalable by Design** | Arsitektur mendukung ribuan form dengan jutaan submission |

### 1.3 Technology Decision

| Komponen | Teknologi | Alasan |
|----------|-----------|--------|
| Backend Framework | Laravel 8.x | Konsisten dengan existing project |
| Database | MySQL 8.0 | Mendukung JSON column, full-text search |
| Cache | File | Session management dan rate limiting |
| File Storage | Google Drive API | Existing integration di project |
| Queue | Database (custom-database driver) | Background job untuk notifikasi email |
| Frontend Admin | Blade + Alpine.js | Lightweight, konsisten dengan project pattern |
| Frontend Public | Blade SSR | SEO friendly, fast initial load |
| Real-time | Polling/SSE | Tidak perlu WebSocket untuk use case ini |

---

## 2. Database Design

### 2.1 Strategi Penyimpanan Data

Setelah mempertimbangkan 4 pendekatan utama, **Hybrid Approach (JSON + Indexed Metadata)** dipilih sebagai solusi optimal:

| Pendekatan | Pros | Cons | Verdict |
|------------|------|------|---------|
| Dynamic Columns | Query cepat, native SQL | Tidak scalable, ALTER TABLE setiap form baru | ❌ Rejected |
| EAV (Entity-Attribute-Value) | Sangat fleksibel | Query kompleks, performance buruk di scale besar | ❌ Rejected |
| Pure JSON Storage | Sangat fleksibel, schema-free | Filtering lambat tanpa indexing | ⚠️ Partial |
| **Hybrid (JSON + Metadata)** | **Fleksibel + performant** | **Sedikit lebih kompleks** | ✅ **Selected** |

### 2.2 Alasan Pemilihan Hybrid Approach

1. **Flexibility**: Form field bisa berubah kapan saja tanpa ALTER TABLE
2. **Performance**: Metadata table untuk filtering/searching yang sering digunakan
3. **Simplicity**: Tidak perlu maintain dynamic schema
4. **Scalability**: JSON compressed storage + indexed metadata untuk query
5. **Export Friendly**: JSON mudah di-parse ke format tabular
6. **MySQL 8.0 Support**: Native JSON functions (JSON_EXTRACT, JSON_SEARCH, etc.)

### 2.3 Database Schema Overview

```
┌──────────────┐     ┌──────────────────┐     ┌────────────────────┐
│   ms_form    │────▶│  ms_form_field   │     │  ms_form_setting   │
│              │     │                  │     │                    │
│ formID (PK)  │     │ formFieldID (PK) │     │ formSettingID (PK) │
│ title        │     │ formID (FK)      │     │ formID (FK)        │
│ slug         │     │ fieldType        │     │ settingKey         │
│ description  │     │ label            │     │ settingValue       │
│ status       │     │ sortOrder        │     └────────────────────┘
│ version      │     │ options (JSON)   │
└──────┬───────┘     └──────────────────┘
       │
       │         ┌───────────────────────┐     ┌──────────────────────┐
       └────────▶│  tr_form_submission   │────▶│  tr_form_answer      │
                 │                       │     │                      │
                 │ formSubmissionID (PK)  │     │ formAnswerID (PK)    │
                 │ formID (FK)           │     │ formSubmissionID (FK) │
                 │ respondentName        │     │ formFieldID (FK)     │
                 │ respondentEmail       │     │ answerValue (TEXT)   │
                 │ submittedAt           │     │ answerFile (JSON)    │
                 │ answersJson (JSON)    │     └──────────────────────┘
                 └───────────────────────┘
```

---

## 3. ERD Concept

### 3.1 Entity Relationship Diagram

```
┌─────────────────────┐         ┌─────────────────────────┐
│      ms_form        │         │     ms_form_field       │
├─────────────────────┤         ├─────────────────────────┤
│ PK formID           │◀───┐    │ PK formFieldID          │
│    title            │    │    │ FK formID               │──┐
│    slug (UNIQUE)    │    │    │    fieldType             │  │
│    description      │    │    │    label                 │  │
│    status           │    │    │    placeholder           │  │
│    version          │    │    │    helpText              │  │
│    themeConfig(JSON)│    │    │    isRequired            │  │
│    maxSubmission    │    │    │    sortOrder             │  │
│    startDate        │    │    │    sectionID             │  │
│    endDate          │    │    │    validation (JSON)     │  │
│    flagActive       │    │    │    options (JSON)        │  │
│    createdBy        │    │    │    defaultValue          │  │
│    createdDate      │    │    │    conditionalLogic(JSON)│  │
│    editedBy         │    │    │    flagActive            │  │
│    editedDate       │    │    │    createdDate           │  │
└─────────┬───────────┘    │    └─────────────────────────┘  │
          │                │                                  │
          │                │    ┌─────────────────────────┐   │
          │                │    │   ms_form_section       │   │
          │                │    ├─────────────────────────┤   │
          │                ├────│ PK formSectionID        │   │
          │                │    │ FK formID               │   │
          │                │    │    title                 │   │
          │                │    │    description           │   │
          │                │    │    sortOrder             │   │
          │                │    └─────────────────────────┘   │
          │                │                                  │
          ▼                │    ┌─────────────────────────┐   │
┌─────────────────────┐    │    │  tr_form_submission     │   │
│  ms_form_setting    │    │    ├─────────────────────────┤   │
├─────────────────────┤    ├────│ PK formSubmissionID     │   │
│ PK formSettingID    │    │    │ FK formID               │   │
│ FK formID           │────┘    │    respondentName       │   │
│    settingKey       │         │    respondentEmail      │   │
│    settingValue     │         │    respondentPhone      │   │
│    settingType      │         │    ipAddress            │   │
└─────────────────────┘         │    userAgent            │   │
                                │    answersJson (JSON)   │   │
                                │    submittedAt          │   │
                                │    flagValid            │   │
                                └────────────┬────────────┘   │
                                             │                │
                                             ▼                │
                                ┌─────────────────────────┐   │
                                │    tr_form_answer       │   │
                                ├─────────────────────────┤   │
                                │ PK formAnswerID         │   │
                                │ FK formSubmissionID     │◀──┘
                                │ FK formFieldID          │
                                │    answerValue (TEXT)   │
                                │    answerFile (JSON)    │
                                │    createdDate          │
                                └─────────────────────────┘

┌─────────────────────┐         ┌─────────────────────────┐
│  tr_form_file       │         │   tr_form_audit_log     │
├─────────────────────┤         ├─────────────────────────┤
│ PK formFileID       │         │ PK formAuditLogID       │
│ FK formSubmissionID │         │ FK formID               │
│ FK formFieldID      │         │    userID               │
│    fileName         │         │    action               │
│    filePath         │         │    payload (JSON)       │
│    fileSize         │         │    ipAddress            │
│    mimeType         │         │    createdDate          │
│    gdriveFileID     │         └─────────────────────────┘
│    createdDate      │
└─────────────────────┘
```

### 3.2 Relationship Summary

| Relationship | Type | Keterangan |
|---|---|---|
| ms_form → ms_form_field | One-to-Many | Satu form memiliki banyak field |
| ms_form → ms_form_section | One-to-Many | Satu form memiliki banyak section |
| ms_form → ms_form_setting | One-to-Many | Satu form memiliki banyak setting |
| ms_form → tr_form_submission | One-to-Many | Satu form memiliki banyak submission |
| tr_form_submission → tr_form_answer | One-to-Many | Satu submission memiliki banyak answer |
| ms_form_field → tr_form_answer | One-to-Many | Satu field bisa memiliki banyak answer dari berbagai submission |
| tr_form_submission → tr_form_file | One-to-Many | Satu submission bisa memiliki banyak file |

---

## 4. Table List

| No | Table Name | Prefix | Tipe | Deskripsi |
|----|-----------|--------|------|-----------|
| 1 | `ms_form` | ms_ | Master | Master data form utama (termasuk GDrive folder/spreadsheet IDs) |
| 2 | `ms_form_field` | ms_ | Master | Definisi field/pertanyaan dalam form |
| 3 | `ms_form_section` | ms_ | Master | Section/group dalam form |
| 4 | `ms_form_setting` | ms_ | Master | Konfigurasi tambahan form |
| 5 | `tr_form_submission` | tr_ | Transaction | **Metadata** submission user (jawaban ada di Google Sheets) |
| ~~6~~ | ~~`tr_form_answer`~~ | ~~tr_~~ | ~~Transaction~~ | ~~Detail jawaban per field~~ **→ DIHAPUS, digantikan Google Sheets** |
| 6 | `tr_form_file` | tr_ | Transaction | File yang diupload user (di-store di GDrive) |
| 7 | `tr_form_audit_log` | tr_ | Transaction | Log aktivitas admin |
| 8 | `map_form_collaborator` | map_ | Mapping | Mapping admin collaborator ke form |

> **Catatan:** `tr_form_answer` tidak digunakan. Jawaban user langsung di-append ke Google Sheets yang dibuat saat admin create form. Total tabel database yang perlu dibuat: **8 tabel**.

---

## 5. Detail Column Tiap Table

### 5.1 Table `ms_form`

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| title | VARCHAR(255) | NOT NULL | - | Judul form |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | - | URL-friendly identifier |
| description | TEXT | NULLABLE | NULL | Deskripsi form |
| status | ENUM('draft','published','closed','archived') | NOT NULL | 'draft' | Status form |
| version | INT UNSIGNED | NOT NULL | 1 | Versi form |
| themeConfig | JSON | NULLABLE | NULL | Konfigurasi tema (warna, font, dll) |
| headerImage | VARCHAR(500) | NULLABLE | NULL | URL header image |
| headerImageGdriveID | VARCHAR(255) | NULLABLE | NULL | Google Drive file ID |
| maxSubmission | INT UNSIGNED | NULLABLE | NULL | Batas maksimal submission (NULL = unlimited) |
| isMultipleSubmit | TINYINT(1) | NOT NULL | 0 | Boleh submit lebih dari 1x |
| requireLogin | TINYINT(1) | NOT NULL | 0 | Wajib login untuk submit |
| startDate | DATETIME | NULLABLE | NULL | Tanggal mulai aktif |
| endDate | DATETIME | NULLABLE | NULL | Tanggal expired |
| confirmationMessage | TEXT | NULLABLE | NULL | Pesan setelah submit |
| redirectUrl | VARCHAR(500) | NULLABLE | NULL | URL redirect setelah submit |
| notifyEmails | JSON | NULLABLE | NULL | Email yang dinotifikasi saat ada submission |
| collaboratorEmails | JSON | NULLABLE | NULL | Email yang dijadikan Editor di folder GDrive form (array of strings) |
| gdriveFolderID | VARCHAR(255) | NULLABLE | NULL | GDrive folder ID untuk folder `{Form Title}/` |
| gdriveSpreadsheetID | VARCHAR(255) | NULLABLE | NULL | GDrive Spreadsheet ID untuk file responses |
| gdriveSpreadsheetUrl | VARCHAR(500) | NULLABLE | NULL | URL direct ke Google Spreadsheet |
| gdriveAttachmentsFolderID | VARCHAR(255) | NULLABLE | NULL | GDrive folder ID untuk subfolder `attachments/` |
| gdriveAttachmentsFolderUrl | VARCHAR(500) | NULLABLE | NULL | URL direct ke folder attachments di GDrive |
| totalSubmission | INT UNSIGNED | NOT NULL | 0 | Counter total submission (denormalized) |
| flagActive | TINYINT(1) | NOT NULL | 1 | Soft delete flag |
| createdBy | VARCHAR(100) | NOT NULL | - | Pembuat form |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Tanggal dibuat |
| editedBy | VARCHAR(100) | NULLABLE | NULL | Editor terakhir |
| editedDate | DATETIME | NULLABLE | NULL | Tanggal edit terakhir |

### 5.2 Table `ms_form_field`

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formFieldID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke ms_form |
| formSectionID | BIGINT UNSIGNED | FK, NULLABLE | NULL | Referensi ke section |
| fieldType | VARCHAR(50) | NOT NULL | - | Tipe input (short_text, dropdown, dll) |
| label | VARCHAR(500) | NOT NULL | - | Label pertanyaan |
| placeholder | VARCHAR(255) | NULLABLE | NULL | Placeholder text |
| helpText | VARCHAR(500) | NULLABLE | NULL | Teks bantuan di bawah field |
| isRequired | TINYINT(1) | NOT NULL | 0 | Wajib diisi |
| sortOrder | INT UNSIGNED | NOT NULL | 0 | Urutan tampil |
| options | JSON | NULLABLE | NULL | Opsi untuk dropdown/radio/checkbox |
| validation | JSON | NULLABLE | NULL | Rule validasi (min, max, pattern, dll) |
| defaultValue | TEXT | NULLABLE | NULL | Nilai default |
| conditionalLogic | JSON | NULLABLE | NULL | Logic kapan field ditampilkan |
| fieldConfig | JSON | NULLABLE | NULL | Konfigurasi tambahan (column width, gdriveFolderID per field, dll) |
| isSystemField | TINYINT(1) | NOT NULL | 0 | 1 = field otomatis oleh sistem (tidak bisa dihapus admin, misal: field email wajib) |
| flagActive | TINYINT(1) | NOT NULL | 1 | Soft delete flag |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Tanggal dibuat |
| editedDate | DATETIME | NULLABLE | NULL | Tanggal edit terakhir |

### 5.3 Table `ms_form_section`

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formSectionID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke ms_form |
| title | VARCHAR(255) | NOT NULL | - | Judul section |
| description | TEXT | NULLABLE | NULL | Deskripsi section |
| sortOrder | INT UNSIGNED | NOT NULL | 0 | Urutan section |
| flagActive | TINYINT(1) | NOT NULL | 1 | Soft delete flag |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Tanggal dibuat |

### 5.4 Table `ms_form_setting`

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formSettingID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke ms_form |
| settingKey | VARCHAR(100) | NOT NULL | - | Key setting (e.g., 'show_progress_bar') |
| settingValue | TEXT | NULLABLE | NULL | Value setting |
| settingType | VARCHAR(50) | NOT NULL | 'string' | Tipe data (string, boolean, json, integer) |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Tanggal dibuat |

### 5.5 Table `tr_form_submission`

> **Catatan Arsitektur (Confirmed):** Tabel ini menyimpan **metadata submission saja**. Jawaban pengguna (answers) **tidak** disimpan di database — melainkan langsung di-append ke Google Sheets yang sudah dibuat saat admin create form. Kolom `gsheetRowIndex` digunakan untuk referensi ke baris spesifik di Spreadsheet.

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formSubmissionID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke ms_form |
| formVersion | INT UNSIGNED | NOT NULL | - | Versi form saat submit |
| userID | BIGINT UNSIGNED | FK, NULLABLE | NULL | User ID jika login |
| respondentName | VARCHAR(255) | NULLABLE | NULL | Nama responden (untuk rate limiting & tracking) |
| respondentEmail | VARCHAR(255) | NULLABLE | NULL | Email responden |
| respondentPhone | VARCHAR(50) | NULLABLE | NULL | Telepon responden |
| gsheetRowIndex | INT UNSIGNED | NULLABLE | NULL | Nomor baris di Google Sheets (untuk referensi silang) |
| ipAddress | VARCHAR(45) | NULLABLE | NULL | IP address submitter |
| userAgent | VARCHAR(500) | NULLABLE | NULL | Browser user agent |
| deviceType | VARCHAR(20) | NULLABLE | NULL | Device type (desktop/mobile/tablet) |
| submittedAt | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Waktu submit |
| duration | INT UNSIGNED | NULLABLE | NULL | Durasi pengisian (detik) |
| flagValid | TINYINT(1) | NOT NULL | 1 | Flag valid/spam |
| flagRead | TINYINT(1) | NOT NULL | 0 | Flag sudah dibaca admin |

### 5.6 Table `tr_form_answer` — ❌ DIHAPUS

> **Keputusan Arsitektur (Confirmed):** Tabel `tr_form_answer` **tidak jadi dibuat**. Jawaban pengguna tidak disimpan di database. Sebagai gantinya, setiap submission langsung di-append sebagai row baru di **Google Sheets** yang dibuat otomatis saat admin membuat form.
>
> **Alasan:**
> - Admin tidak perlu query database untuk melihat hasil — cukup buka Google Sheets
> - Jawaban tetap tersedia meski aplikasi down (data ada di GDrive)
> - Rate limiting & anti-spam tetap bisa dilakukan via `tr_form_submission` (metadata)
> - Tidak perlu implementasi spreadsheet viewer custom di admin panel
>
> **Data di database (minimal):** `tr_form_submission` menyimpan metadata (IP, timestamp, userAgent, gsheetRowIndex)
> **Data jawaban:** Di Google Sheets (kolom sesuai field form)

### 5.7 Table `tr_form_file`

> **Catatan:** File attachment langsung disimpan di Google Drive (bukan local storage). Kolom `filePath` dan `storedName` tidak digunakan — hanya GDrive ID yang disimpan sebagai referensi.

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formFileID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formSubmissionID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke submission |
| formFieldID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke field |
| originalName | VARCHAR(255) | NOT NULL | - | Nama file asli (dari user) |
| fileSize | BIGINT UNSIGNED | NOT NULL | - | Ukuran file (bytes) |
| mimeType | VARCHAR(100) | NOT NULL | - | MIME type file |
| gdriveFileID | VARCHAR(255) | NOT NULL | - | Google Drive file ID |
| gdriveFolderID | VARCHAR(255) | NOT NULL | - | GDrive folder ID tempat file disimpan (subfolder field) |
| gdriveFileUrl | VARCHAR(500) | NULLABLE | NULL | URL langsung ke file di GDrive |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Tanggal upload |

### 5.8 Table `tr_form_audit_log`

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formAuditLogID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formID | BIGINT UNSIGNED | FK, NULLABLE | NULL | Referensi ke form (NULL jika form dihapus) |
| userID | BIGINT UNSIGNED | NOT NULL | - | User yang melakukan aksi |
| action | VARCHAR(50) | NOT NULL | - | Tipe aksi (created, updated, published, deleted, exported) |
| description | VARCHAR(500) | NULLABLE | NULL | Deskripsi aksi |
| payload | JSON | NULLABLE | NULL | Data perubahan (before/after) |
| ipAddress | VARCHAR(45) | NULLABLE | NULL | IP address |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Waktu aksi |

### 5.9 Table `map_form_collaborator`

| Column | Type | Constraint | Default | Deskripsi |
|--------|------|-----------|---------|-----------|
| formCollaboratorID | BIGINT UNSIGNED | PK, AUTO_INCREMENT | - | Primary key |
| formID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke form |
| userID | BIGINT UNSIGNED | FK, NOT NULL | - | Referensi ke user |
| permission | ENUM('view','edit','manage') | NOT NULL | 'view' | Level permission |
| createdDate | DATETIME | NOT NULL | CURRENT_TIMESTAMP | Tanggal ditambahkan |
| createdBy | VARCHAR(100) | NOT NULL | - | Yang menambahkan |

---

## 6. Data Type Recommendation

### 6.1 Pemilihan Data Type

| Kebutuhan | Type yang Dipilih | Alasan |
|-----------|------------------|--------|
| Primary Key | BIGINT UNSIGNED | Mendukung auto-increment hingga 18 quintillion record |
| Short Text | VARCHAR(255) | Standard max untuk indexed columns |
| Long Text | TEXT | Unlimited practical length, tidak di-index langsung |
| JSON Data | JSON (native) | MySQL 8.0 native JSON support dengan partial indexing |
| Boolean | TINYINT(1) | Standard Laravel boolean representation |
| Datetime | DATETIME | Timezone handling di application layer |
| Enum | ENUM | Type-safe, storage efficient untuk fixed options |
| File Size | BIGINT UNSIGNED | Mendukung file hingga exabyte |
| IP Address | VARCHAR(45) | Mendukung IPv6 full format |
| Decimal | DECIMAL(15,4) | Precision tinggi untuk numeric answers |

### 6.2 JSON Column Strategy

JSON columns digunakan untuk data yang:
- Berbeda struktur antar record (dynamic options)
- Tidak perlu di-query secara langsung (theme config)
- Memiliki nested structure (conditional logic)
- Array of values (multiple choice answers)

```sql
-- Contoh query JSON di MySQL 8.0
SELECT * FROM tr_form_submission
WHERE JSON_EXTRACT(answersJson, '$.field_5') = 'Jakarta';

-- Virtual generated column untuk indexing
ALTER TABLE tr_form_submission
ADD COLUMN respondentEmailIdx VARCHAR(255)
GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(answersJson, '$.email'))) STORED;
```

---

## 7. Index Recommendation

### 7.1 Primary Indexes

```sql
-- ms_form
PRIMARY KEY (formID)
UNIQUE INDEX idx_form_slug (slug)
INDEX idx_form_status (status, flagActive)
INDEX idx_form_dates (startDate, endDate)
INDEX idx_form_created (createdDate DESC)

-- ms_form_field
PRIMARY KEY (formFieldID)
INDEX idx_field_form (formID, sortOrder)
INDEX idx_field_section (formSectionID, sortOrder)
INDEX idx_field_type (formID, fieldType)

-- ms_form_section
PRIMARY KEY (formSectionID)
INDEX idx_section_form (formID, sortOrder)

-- ms_form_setting
PRIMARY KEY (formSettingID)
UNIQUE INDEX idx_setting_form_key (formID, settingKey)

-- tr_form_submission
PRIMARY KEY (formSubmissionID)
INDEX idx_submission_form (formID, submittedAt DESC)
INDEX idx_submission_email (respondentEmail)
INDEX idx_submission_valid (formID, flagValid, submittedAt DESC)
INDEX idx_submission_date (submittedAt DESC)

-- tr_form_answer
PRIMARY KEY (formAnswerID)
INDEX idx_answer_submission (formSubmissionID)
INDEX idx_answer_field (formFieldID, answerValue(100))
INDEX idx_answer_numeric (formFieldID, answerNumeric)
INDEX idx_answer_date (formFieldID, answerDate)

-- tr_form_file
PRIMARY KEY (formFileID)
INDEX idx_file_submission (formSubmissionID)
INDEX idx_file_field (formFieldID)

-- tr_form_audit_log
PRIMARY KEY (formAuditLogID)
INDEX idx_audit_form (formID, createdDate DESC)
INDEX idx_audit_user (userID, createdDate DESC)
INDEX idx_audit_action (action, createdDate DESC)

-- map_form_collaborator
PRIMARY KEY (formCollaboratorID)
UNIQUE INDEX idx_collab_form_user (formID, userID)
INDEX idx_collab_user (userID)
```

### 7.2 Index Strategy Notes

1. **Composite Index Order**: Kolom dengan kardinalitas tinggi di depan
2. **Covering Index**: Include semua kolom yang sering di-SELECT
3. **Prefix Index**: Untuk TEXT columns gunakan prefix length `answerValue(100)`
4. **Partial Index**: Gunakan WHERE clause pada index jika MySQL mendukung
5. **Hindari Over-indexing**: Setiap index menambah overhead pada INSERT/UPDATE

---

## 8. Relationship Antar Table

### 8.1 Foreign Key Constraints

```sql
-- ms_form_field
ALTER TABLE ms_form_field
  ADD CONSTRAINT fk_field_form
  FOREIGN KEY (formID) REFERENCES ms_form(formID) ON DELETE CASCADE,
  ADD CONSTRAINT fk_field_section
  FOREIGN KEY (formSectionID) REFERENCES ms_form_section(formSectionID) ON DELETE SET NULL;

-- ms_form_section
ALTER TABLE ms_form_section
  ADD CONSTRAINT fk_section_form
  FOREIGN KEY (formID) REFERENCES ms_form(formID) ON DELETE CASCADE;

-- ms_form_setting
ALTER TABLE ms_form_setting
  ADD CONSTRAINT fk_setting_form
  FOREIGN KEY (formID) REFERENCES ms_form(formID) ON DELETE CASCADE;

-- tr_form_submission
ALTER TABLE tr_form_submission
  ADD CONSTRAINT fk_submission_form
  FOREIGN KEY (formID) REFERENCES ms_form(formID) ON DELETE RESTRICT;

-- tr_form_answer
ALTER TABLE tr_form_answer
  ADD CONSTRAINT fk_answer_submission
  FOREIGN KEY (formSubmissionID) REFERENCES tr_form_submission(formSubmissionID) ON DELETE CASCADE,
  ADD CONSTRAINT fk_answer_field
  FOREIGN KEY (formFieldID) REFERENCES ms_form_field(formFieldID) ON DELETE RESTRICT;

-- tr_form_file
ALTER TABLE tr_form_file
  ADD CONSTRAINT fk_file_submission
  FOREIGN KEY (formSubmissionID) REFERENCES tr_form_submission(formSubmissionID) ON DELETE CASCADE,
  ADD CONSTRAINT fk_file_field
  FOREIGN KEY (formFieldID) REFERENCES ms_form_field(formFieldID) ON DELETE RESTRICT;

-- tr_form_audit_log
ALTER TABLE tr_form_audit_log
  ADD CONSTRAINT fk_audit_form
  FOREIGN KEY (formID) REFERENCES ms_form(formID) ON DELETE SET NULL;

-- map_form_collaborator
ALTER TABLE map_form_collaborator
  ADD CONSTRAINT fk_collab_form
  FOREIGN KEY (formID) REFERENCES ms_form(formID) ON DELETE CASCADE,
  ADD CONSTRAINT fk_collab_user
  FOREIGN KEY (userID) REFERENCES users(id) ON DELETE CASCADE;
```

### 8.2 Cascade Strategy

| Relasi | ON DELETE | Alasan |
|--------|----------|--------|
| form → field | CASCADE | Field tidak berguna tanpa form |
| form → section | CASCADE | Section tidak berguna tanpa form |
| form → setting | CASCADE | Setting tidak berguna tanpa form |
| form → submission | RESTRICT | Submission adalah data penting, tidak boleh hilang |
| submission → answer | CASCADE | Answer selalu mengikuti submission |
| submission → file | CASCADE | File terikat ke submission |
| form → audit_log | SET NULL | Log tetap tersimpan meski form dihapus |
| form → collaborator | CASCADE | Collaborator mapping tidak relevan tanpa form |

---

## 9. Form Builder Flow

### 9.1 Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    ADMIN: CREATE FORM                            │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 1: Basic Information                                       │
│ - Input judul form                                              │
│ - Input deskripsi                                               │
│ - Auto-generate slug dari judul                                 │
│ - Pilih tema/warna                                              │
│ - Upload header image (optional)                                │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 2: Form Builder (Drag & Drop)                              │
│ - Sidebar: daftar field types                                   │
│ - Canvas: area preview form                                     │
│ - Drag field type ke canvas                                     │
│ - Klik field untuk edit properties                              │
│ - Reorder field dengan drag                                     │
│ - Group field ke dalam section                                  │
│ - Set required/optional                                         │
│ - Set validation rules                                          │
│ - Set conditional logic (future)                                │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 3: Settings                                                │
│ - Set max submission limit                                      │
│ - Set start date & end date                                     │
│ - Allow multiple submission                                     │
│ - Require login                                                 │
│ - Confirmation message                                          │
│ - Redirect URL after submit                                     │
│ - Notification emails                                           │
│ - Collaborator management                                       │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 4: Preview & Test                                          │
│ - Preview form seperti yang akan dilihat user                   │
│ - Test submit (data tidak disimpan)                             │
│ - Check responsive display                                      │
│ - Validate semua field berfungsi                                │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 5: Save & Publish                                          │
│ - Save as Draft (bisa edit lagi)                                │
│ - Publish (langsung aktif)                                      │
│ - Schedule (publish otomatis di startDate)                      │
│ - Generate public URL                                           │
│ - Copy link / share                                             │
└─────────────────────────────────────────────────────────────────┘
```

### 9.2 Field Type Configuration

| Field Type | Options Required | Validation Options |
|------------|-----------------|-------------------|
| short_text | maxLength | min, max, pattern (regex) |
| long_text | maxLength, rows | min, max |
| email | - | format validation |
| phone | countryCode | format, min, max digits |
| number | min, max, step | integer/decimal, range |
| date | minDate, maxDate, format | before/after |
| time | format (12h/24h) | min, max |
| datetime | minDatetime, maxDatetime | before/after |
| dropdown | options[] | - |
| multiple_choice | options[], layout | min/max selections |
| checkbox | options[] | min/max selections |
| file_upload | allowedTypes[], maxSize | size limit |
| image_upload | allowedTypes[], maxSize, maxDimension | size, dimension |
| rating | maxStars, icon | - |
| linear_scale | minValue, maxValue, minLabel, maxLabel | - |
| yes_no | style (toggle/radio) | - |
| url | - | format validation |
| section_divider | - | - (non-input) |
| description_text | content (rich text) | - (non-input) |
| hidden_field | value | - |

---

## 10. Submission Flow

### 10.1 Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                USER: MENGISI FORM                                │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 1: Access Form via Public URL                              │
│ - GET /form/{slug}                                              │
│ - Validate: form exists, published, not expired                 │
│ - Validate: max submission not reached                          │
│ - Validate: login required? redirect if needed                  │
│ - Record start time (untuk duration tracking)                   │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 2: Render Dynamic Form                                     │
│ - Load form fields dari database                                │
│ - Render sesuai fieldType                                       │
│ - Apply conditional logic (show/hide)                           │
│ - Apply default values                                          │
│ - Load theme configuration                                      │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 3: User Fills Form                                         │
│ - Client-side validation (real-time)                            │
│ - File upload: immediate upload ke temp storage                 │
│ - Auto-save draft (optional, localStorage)                      │
│ - Progress indicator jika multi-section                         │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 4: Submit Form                                             │
│ - POST /form/{slug}/submit                                      │
│ - Server-side validation (all fields)                           │
│ - Anti-spam check (honeypot, rate limit, timing)                │
│ - CSRF token validation                                         │
│ - File validation (size, type, virus scan)                      │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                    ┌───────┴───────┐
                    │  Valid?       │
                    └───────┬───────┘
               ┌────────────┴────────────┐
               ▼                         ▼
        ┌──────────┐              ┌──────────────┐
        │   YES    │              │      NO      │
        └────┬─────┘              └──────┬───────┘
             │                           │
             │                           ▼
             │                    ┌──────────────┐
             │                    │ Return error │
             │                    │ messages     │
             │                    └──────────────┘
             ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 5: Process Submission (Confirmed Hybrid Architecture)      │
│                                                                 │
│ [A] Append ke Google Sheets:                                    │
│   - Ambil gdriveSpreadsheetID dari ms_form                      │
│   - Append row baru ke Spreadsheet (via Google Sheets API)      │
│   - Dapatkan nomor baris hasil append (gsheetRowIndex)          │
│                                                                 │
│ [B] Upload file ke GDrive (jika ada field file/image):          │
│   - Upload file ke subfolder field di GDrive                    │
│   - Simpan gdriveFileID & gdriveFileUrl                         │
│   - Update cell di Spreadsheet dengan link file GDrive          │
│                                                                 │
│ [C] Insert metadata ke database:                                │
│   - Insert tr_form_submission (metadata: IP, UA, gsheetRowIndex)│
│   - Insert tr_form_file (GDrive IDs per file attachment)        │
│   - Update ms_form.totalSubmission + 1                          │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│ Step 6: Post-Submission                                         │
│ - Dispatch notification job (email ke admin)                    │
│ - Dispatch WhatsApp notification (Fonnte)                       │
│ - Log audit trail                                               │
│ - Show confirmation message / redirect                          │
│ - Clear localStorage draft                                      │
└─────────────────────────────────────────────────────────────────┘
```

### 10.2 Submission Data Structure

```json
{
  "formSubmissionID": 1,
  "formID": 5,
  "formVersion": 2,
  "respondentName": "Ahmad Fauzi",
  "respondentEmail": "ahmad@email.com",
  "answersJson": {
    "field_1": "Ahmad Fauzi",
    "field_2": "ahmad@email.com",
    "field_3": "Saya ingin mendaftar program...",
    "field_4": ["option_a", "option_c"],
    "field_5": "2026-06-15",
    "field_6": {
      "fileId": "abc123",
      "fileName": "ktp.jpg",
      "fileSize": 245000
    },
    "field_7": 4,
    "field_8": true
  },
  "submittedAt": "2026-05-20T14:30:00+07:00",
  "duration": 185
}
```

---

## 11. Spreadsheet Result Flow

### 11.1 Konsep Spreadsheet View

Spreadsheet view menampilkan submission data dalam format tabel seperti Google Sheets, dimana:
- **Kolom** = Field dari form (dinamis)
- **Baris** = Setiap submission dari user
- **Header** = Label field

### 11.2 Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                  SPREADSHEET VIEW ARCHITECTURE                   │
└─────────────────────────────────────────────────────────────────┘

┌──────────────┐     ┌───────────────────┐     ┌────────────────┐
│  Admin View  │────▶│  API Controller   │────▶│    Service     │
│              │     │                   │     │                │
│ - DataTable  │◀────│ GET /admin/form/  │◀────│ - Query JSON   │
│ - Filter     │     │   {id}/responses  │     │ - Parse Fields │
│ - Sort       │     │                   │     │ - Paginate     │
│ - Export     │     │ Params:           │     │ - Format       │
│ - Search     │     │ - page            │     │                │
└──────────────┘     │ - perPage         │     └───────┬────────┘
                     │ - sort            │             │
                     │ - filter          │             ▼
                     │ - search          │     ┌────────────────┐
                     │ - export          │     │    Database    │
                     └───────────────────┘     │                │
                                               │ JSON_EXTRACT() │
                                               │ + Metadata     │
                                               └────────────────┘
```

### 11.3 Data Loading Strategy

```php
// Strategy: Lazy Loading dengan Server-Side Processing
// 1. Load field definitions (header columns)
// 2. Query submissions dengan pagination
// 3. Parse JSON answers ke tabular format
// 4. Return paginated result

// Pseudo-code
public function getSpreadsheetData($formID, Request $request)
{
    // Get column definitions
    $fields = MsFormField::where('formID', $formID)
        ->where('flagActive', 1)
        ->orderBy('sortOrder')
        ->get();

    // Build query
    $query = TrFormSubmission::where('formID', $formID)
        ->where('flagValid', 1);

    // Apply search (across JSON)
    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search, $fields) {
            foreach ($fields as $field) {
                $q->orWhereRaw(
                    "JSON_UNQUOTE(JSON_EXTRACT(answersJson, ?)) LIKE ?",
                    ['$.field_' . $field->formFieldID, "%{$search}%"]
                );
            }
        });
    }

    // Apply specific field filter
    if ($filters = $request->input('filters')) {
        foreach ($filters as $fieldID => $value) {
            $query->whereRaw(
                "JSON_UNQUOTE(JSON_EXTRACT(answersJson, ?)) = ?",
                ['$.field_' . $fieldID, $value]
            );
        }
    }

    // Sort
    $sortField = $request->input('sort_field', 'submittedAt');
    $sortDir = $request->input('sort_dir', 'desc');

    if ($sortField === 'submittedAt') {
        $query->orderBy('submittedAt', $sortDir);
    } else {
        // Sort by JSON field value
        $query->orderByRaw(
            "JSON_UNQUOTE(JSON_EXTRACT(answersJson, ?)) {$sortDir}",
            ['$.field_' . $sortField]
        );
    }

    return $query->paginate($request->input('perPage', 25));
}
```

### 11.4 Export Strategy

| Format | Library | Use Case |
|--------|---------|----------|
| Excel (.xlsx) | PhpSpreadsheet / Maatwebsite Excel | Data lengkap dengan formatting |
| CSV | Native PHP fputcsv | Data ringan, cepat |
| PDF | DomPDF (existing) | Summary report |

```
Export Flow:
1. Admin klik "Export"
2. Pilih format (Excel/CSV/PDF)
3. Pilih filter (semua/filtered/selected)
4. System dispatch background job
5. Job process data chunk by chunk
6. Generate file, simpan ke temp
7. Notify admin (realtime/email)
8. Admin download file
9. Auto-cleanup file setelah 24 jam
```

---

## 12. Public Form Security

### 12.1 Security Layers

```
┌─────────────────────────────────────────────────────────────────┐
│ Layer 1: CSRF Protection                                        │
│ - Laravel CSRF token di setiap form                             │
│ - Token di-refresh setiap session                               │
└─────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────┐
│ Layer 2: Rate Limiting                                          │
│ - Max 5 submission per IP per 10 menit                          │
│ - Max 20 submission per IP per jam                              │
│ - Customizable per form                                         │
└─────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────┐
│ Layer 3: Anti-Bot Protection                                    │
│ - Honeypot hidden field                                         │
│ - Minimum time check (< 3 detik = bot)                          │
│ - JavaScript token generation                                   │
└─────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────┐
│ Layer 4: Input Sanitization                                     │
│ - XSS prevention (htmlspecialchars)                             │
│ - SQL injection prevention (parameterized queries)              │
│ - File type validation (magic bytes, bukan hanya extension)     │
└─────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────┐
│ Layer 5: Access Control                                         │
│ - Form published? Active? Not expired?                          │
│ - Max submission reached?                                       │
│ - Login required?                                               │
│ - IP blacklist check                                            │
└─────────────────────────────────────────────────────────────────┘
```

### 12.2 Honeypot Implementation

```html
<!-- Hidden field yang hanya bot yang akan isi -->
<div style="position:absolute;left:-9999px;top:-9999px;">
    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
</div>
```

```php
// Server-side check
if (!empty($request->input('website_url'))) {
    // Bot detected - silently reject
    return response()->json(['success' => true]); // Fake success
}
```

### 12.3 Timing Check

```php
// Di form, simpan timestamp mulai
<input type="hidden" name="_form_started" value="{{ encrypt(time()) }}">

// Di server
$startTime = decrypt($request->input('_form_started'));
$duration = time() - $startTime;

if ($duration < 3) {
    // Terlalu cepat, kemungkinan bot
    Log::warning('Possible bot submission', ['ip' => $request->ip()]);
    // Silent reject atau flag as spam
}
```

---

## 13. File Upload Strategy

> **Keputusan Arsitektur (Confirmed):** File attachment **langsung dikirim ke Google Drive** — tidak ada penyimpanan lokal (`local storage`). Folder dibuat otomatis per field saat admin membuat form, sehingga setiap upload langsung masuk ke folder yang sudah tersedia.

### 13.1 Upload Flow (GDrive-Only)

```
┌────────────┐     ┌────────────────┐     ┌──────────────────────────────┐
│   Client   │────▶│  Server (PHP)  │────▶│        Google Drive          │
│            │     │                │     │                              │
│ File Input │     │ - Validation   │     │  dynamic_form/               │
│ + Preview  │     │ - Mime check   │     │  └── {Form Title}/           │
│ + Progress │     │ - Size check   │     │       └── attachments/       │
└────────────┘     └───────┬────────┘     │            └── {field_label}/│
                           │              │                 └── file.ext  │
                           │ Upload via   └──────────────────────────────┘
                           │ GDrive API
                           ▼
                   ┌────────────────┐
                   │ tr_form_file   │
                   │                │
                   │ gdriveFileID   │
                   │ gdriveFolderID │
                   │ gdriveFileUrl  │
                   └────────────────┘
```

### 13.2 GDrive Folder Structure (Confirmed)

```
dynamic_form/  (Root GDrive Folder ID: 1L-rydt4-GIgLo_jHw2BdJkFT4MZw7kvX)
├── {Form Title A}/                          ← dibuat saat admin create form
│   ├── {Form Title A} Responses.xlsx        ← Google Sheets untuk jawaban
│   └── attachments/                         ← folder untuk file upload
│       ├── {label_field_upload_1}/          ← dibuat per field file/image
│       │   ├── submission_123_cv.pdf        ← file dari user (submission 123)
│       │   └── submission_456_cv.pdf        ← file dari user (submission 456)
│       └── {label_field_upload_2}/
│           ├── submission_123_photo.jpg
│           └── submission_456_photo.png
│
├── {Form Title B}/                          ← form lain
│   ├── {Form Title B} Responses.xlsx
│   └── attachments/
│       └── {label_field_1}/
│           └── ...
```

**Aturan penamaan file user:** `submission_{submissionID}_{originalFileName}` untuk menghindari konflik nama file.

### 13.3 GDrive Permission untuk Collaborator

Ketika admin membuat form dan mengisi field **Collaborator Email**:
- Email tersebut diberi akses **Editor** pada folder `{Form Title}/`
- Artinya collaborator bisa melihat & mengedit Spreadsheet dan folder attachments
- Permission di-set via Google Drive API (`permissions.create` dengan role `writer`)

```
// Scope permission yang dibutuhkan:
// https://www.googleapis.com/auth/drive (sudah ada di project)
// Permission diberikan ke FOLDER, bukan ke file individual
```

### 13.4 File Naming & Upload Convention

| Komponen | Format | Contoh |
|----------|--------|--------|
| File user di GDrive | `submission_{ID}_{originalName}` | `submission_42_cv.pdf` |
| Folder per field | Label field (sanitized) | `Foto KTP`, `Upload CV` |
| Folder per form | Title form (sanitized) | `Pendaftaran Magang 2026` |

### 13.5 File Validation Rules

| File Type | Allowed Extensions | Max Size | Additional Check |
|-----------|-------------------|----------|-----------------|
| Document | pdf, doc, docx, xls, xlsx | 10MB | Magic bytes verification |
| Image | jpg, jpeg, png, gif, webp | 5MB | Dimension check, EXIF strip |
| Video | mp4, avi, mov | 50MB | Duration limit (optional) |
| Audio | mp3, wav, ogg | 20MB | Duration limit (optional) |
| Archive | zip, rar | 25MB | Content scan |

### 13.6 Yang Ditampilkan di Admin Page

Admin hanya perlu melihat **2 link GDrive** per form (bukan daftar file individual):

| Link | Deskripsi |
|------|-----------|
| Spreadsheet Link (`gdriveSpreadsheetUrl`) | Link langsung ke Google Sheets responses |
| Attachments Folder Link (`gdriveAttachmentsFolderUrl`) | Link ke folder attachments di GDrive |

---

## 14. Validation Strategy

### 14.1 Two-Layer Validation

```
┌─────────────────────────────────────────────────────────────────┐
│                  CLIENT-SIDE VALIDATION (UX)                     │
├─────────────────────────────────────────────────────────────────┤
│ - Real-time feedback saat user mengetik                         │
│ - Required field indicator                                      │
│ - Format validation (email, phone, URL)                         │
│ - Min/max length counter                                        │
│ - File size/type check sebelum upload                           │
│ - Conditional field show/hide                                   │
│ - Custom error messages                                         │
│                                                                 │
│ Implementation: Vanilla JS + data attributes                    │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                 SERVER-SIDE VALIDATION (Security)                │
├─────────────────────────────────────────────────────────────────┤
│ - SELURUH validasi diulang di server                            │
│ - Required check                                                │
│ - Data type validation                                          │
│ - Business rule validation                                      │
│ - File content validation (magic bytes)                         │
│ - Anti-XSS sanitization                                         │
│ - Cross-field validation                                        │
│                                                                 │
│ Implementation: Laravel Validator + Custom Rules                 │
└─────────────────────────────────────────────────────────────────┘
```

### 14.2 Validation Rules per Field Type

```php
// Dynamic validation builder
class FormValidationBuilder
{
    public static function buildRules(Collection $fields): array
    {
        $rules = [];

        foreach ($fields as $field) {
            $fieldKey = 'answers.field_' . $field->formFieldID;
            $fieldRules = [];

            // Required check
            if ($field->isRequired) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            // Type-specific rules
            switch ($field->fieldType) {
                case 'short_text':
                    $fieldRules[] = 'string';
                    $fieldRules[] = 'max:' . ($field->validation['maxLength'] ?? 255);
                    break;
                case 'email':
                    $fieldRules[] = 'email:rfc,dns';
                    break;
                case 'phone':
                    $fieldRules[] = 'regex:/^[\+]?[0-9\-\s]{8,20}$/';
                    break;
                case 'number':
                    $fieldRules[] = 'numeric';
                    if (isset($field->validation['min'])) {
                        $fieldRules[] = 'min:' . $field->validation['min'];
                    }
                    if (isset($field->validation['max'])) {
                        $fieldRules[] = 'max:' . $field->validation['max'];
                    }
                    break;
                case 'date':
                    $fieldRules[] = 'date';
                    break;
                case 'dropdown':
                case 'multiple_choice':
                    $options = collect($field->options)->pluck('value')->toArray();
                    $fieldRules[] = 'in:' . implode(',', $options);
                    break;
                case 'checkbox':
                    $fieldRules[] = 'array';
                    break;
                case 'file_upload':
                case 'image_upload':
                    $fieldRules[] = 'file';
                    $fieldRules[] = 'max:' . ($field->validation['maxSize'] ?? 10240);
                    break;
                case 'rating':
                    $fieldRules[] = 'integer';
                    $fieldRules[] = 'between:1,' . ($field->options['maxStars'] ?? 5);
                    break;
                case 'url':
                    $fieldRules[] = 'url';
                    break;
                case 'yes_no':
                    $fieldRules[] = 'boolean';
                    break;
            }

            $rules[$fieldKey] = $fieldRules;
        }

        return $rules;
    }
}
```

---

## 15. Scalability Strategy

### 15.1 Database Scalability

| Aspek | Strategi | Threshold |
|-------|----------|-----------|
| Table Size | Partition tr_form_submission by month | > 1M rows |
| Query Speed | JSON virtual columns + indexes | Query > 500ms |
| Read Load | Read replica / Cache layer | > 100 req/s |
| Write Load | Queue submission processing | > 50 req/s |
| Storage | Archive old submissions | > 6 months |

### 15.2 Table Partitioning Strategy

```sql
-- Partition by submission date (monthly)
ALTER TABLE tr_form_submission
PARTITION BY RANGE (YEAR(submittedAt) * 100 + MONTH(submittedAt)) (
    PARTITION p202605 VALUES LESS THAN (202606),
    PARTITION p202606 VALUES LESS THAN (202607),
    PARTITION p202607 VALUES LESS THAN (202608),
    PARTITION pmax VALUES LESS THAN MAXVALUE
);
```

### 15.3 Caching Strategy

```
┌─────────────────────────────────────────────────────────────────┐
│                     CACHING LAYERS                               │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ L1: Application Cache (File driver)                             │
│ ├── Form definition cache (TTL: 5 min)                          │
│ ├── Field list cache per form (TTL: 5 min)                      │
│ ├── Total submission count (TTL: 1 min)                         │
│ └── Spreadsheet page cache (TTL: 30 sec)                        │
│                                                                 │
│ L2: Query Cache (MySQL)                                         │
│ └── Repeated JSON_EXTRACT queries                               │
│                                                                 │
│ L3: Browser Cache                                               │
│ ├── Static form assets (JS/CSS) (TTL: 1 day)                   │
│ └── Form theme config (TTL: 5 min)                              │
│                                                                 │
│ Cache Invalidation:                                             │
│ ├── On form edit → clear form definition cache                  │
│ ├── On new submission → clear count + spreadsheet cache         │
│ └── On field change → clear field list cache                    │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 15.4 Archival Strategy

```
Aktif   : 0-3 bulan    → Primary database, full index
Warm    : 3-6 bulan    → Primary database, reduced index
Cold    : 6-12 bulan   → Archive table, minimal index
Frozen  : > 12 bulan   → Export ke file storage, hapus dari DB
```

---

## 16. API Structure Recommendation

### 16.1 Admin API Endpoints

```
┌────────────────────────────────────────────────────────────────────────────┐
│ FORM MANAGEMENT                                                            │
├────────────────────────────────────────────────────────────────────────────┤
│ GET    /admin/dynamic-form                      → List semua form          │
│ GET    /admin/dynamic-form/create               → Form builder page        │
│ POST   /admin/dynamic-form/store                → Simpan form baru         │
│ GET    /admin/dynamic-form/{id}                 → Detail form              │
│ GET    /admin/dynamic-form/{id}/edit            → Edit form builder        │
│ PUT    /admin/dynamic-form/{id}/update          → Update form              │
│ DELETE /admin/dynamic-form/{id}                 → Delete form              │
│ POST   /admin/dynamic-form/bulk-delete          → Bulk delete              │
│ POST   /admin/dynamic-form/{id}/duplicate       → Duplicate form           │
│ PUT    /admin/dynamic-form/{id}/publish         → Publish form             │
│ PUT    /admin/dynamic-form/{id}/close           → Close form               │
│ PUT    /admin/dynamic-form/{id}/archive         → Archive form             │
├────────────────────────────────────────────────────────────────────────────┤
│ FIELD MANAGEMENT                                                           │
├────────────────────────────────────────────────────────────────────────────┤
│ GET    /admin/dynamic-form/{id}/fields          → List fields              │
│ POST   /admin/dynamic-form/{id}/fields          → Add field                │
│ PUT    /admin/dynamic-form/{id}/fields/{fid}    → Update field             │
│ DELETE /admin/dynamic-form/{id}/fields/{fid}    → Delete field             │
│ POST   /admin/dynamic-form/{id}/fields/reorder  → Reorder fields           │
├────────────────────────────────────────────────────────────────────────────┤
│ SUBMISSION / SPREADSHEET                                                   │
├────────────────────────────────────────────────────────────────────────────┤
│ GET    /admin/dynamic-form/{id}/responses       → Spreadsheet view         │
│ GET    /admin/dynamic-form/{id}/responses/{sid} → Detail submission        │
│ DELETE /admin/dynamic-form/{id}/responses/{sid} → Delete submission        │
│ POST   /admin/dynamic-form/{id}/responses/bulk-delete → Bulk delete        │
│ PUT    /admin/dynamic-form/{id}/responses/{sid}/flag  → Flag spam/valid    │
│ GET    /admin/dynamic-form/{id}/export          → Export data              │
│ GET    /admin/dynamic-form/{id}/analytics       → Form analytics           │
├────────────────────────────────────────────────────────────────────────────┤
│ SETTINGS                                                                   │
├────────────────────────────────────────────────────────────────────────────┤
│ GET    /admin/dynamic-form/{id}/settings        → Get settings             │
│ PUT    /admin/dynamic-form/{id}/settings        → Update settings          │
│ GET    /admin/dynamic-form/{id}/collaborators   → List collaborators       │
│ POST   /admin/dynamic-form/{id}/collaborators   → Add collaborator         │
│ DELETE /admin/dynamic-form/{id}/collaborators/{uid} → Remove collaborator  │
└────────────────────────────────────────────────────────────────────────────┘
```

### 16.2 Public API Endpoints

```
┌────────────────────────────────────────────────────────────────────────────┐
│ PUBLIC FORM                                                                │
├────────────────────────────────────────────────────────────────────────────┤
│ GET    /form/{slug}                             → Render form page         │
│ POST   /form/{slug}/submit                      → Submit form              │
│ POST   /form/{slug}/upload-temp                 → Upload file temporarily  │
│ DELETE /form/{slug}/upload-temp/{fileId}         → Remove temp file         │
│ GET    /form/{slug}/check-availability          → Check if form available  │
└────────────────────────────────────────────────────────────────────────────┘
```

### 16.3 Route Definition

```php
// routes/web.php

// Public form routes
Route::middleware('throttle:30,1')->prefix('/form')->name('form.')->group(function () {
    Route::get('/{slug}', [PublicFormController::class, 'show'])->name('show');
    Route::post('/{slug}/submit', [PublicFormController::class, 'submit'])->name('submit');
    Route::post('/{slug}/upload-temp', [PublicFormController::class, 'uploadTemp'])->name('upload-temp');
    Route::delete('/{slug}/upload-temp/{fileId}', [PublicFormController::class, 'removeTempFile'])->name('remove-temp');
});

// Admin form routes (semua role kecuali 'user')
Route::middleware(['auth', 'role:Superadmin|HelperAdmin|HelperCelsyahid|HelperMedia|HelperSPAM|HelperLetter|HelperEventMart'])
    ->prefix('/admin/dynamic-form')
    ->name('admin.dynamic-form.')
    ->group(function () {
        // CRUD
        Route::get('/', [DynamicFormController::class, 'indexAdmin'])->name('index');
        Route::get('/create', [DynamicFormController::class, 'create'])->name('create');
        Route::post('/store', [DynamicFormController::class, 'store'])->name('store');
        Route::get('/{id}', [DynamicFormController::class, 'showAdmin'])->name('show');
        Route::get('/{id}/edit', [DynamicFormController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [DynamicFormController::class, 'update'])->name('update');
        Route::delete('/{id}', [DynamicFormController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [DynamicFormController::class, 'bulkDelete'])->name('bulk-delete');

        // Actions
        Route::post('/{id}/duplicate', [DynamicFormController::class, 'duplicate'])->name('duplicate');
        Route::put('/{id}/publish', [DynamicFormController::class, 'publish'])->name('publish');
        Route::put('/{id}/close', [DynamicFormController::class, 'close'])->name('close');

        // Fields (AJAX)
        Route::get('/{id}/fields', [DynamicFormFieldController::class, 'index'])->name('fields.index');
        Route::post('/{id}/fields', [DynamicFormFieldController::class, 'store'])->name('fields.store');
        Route::put('/{id}/fields/{fid}', [DynamicFormFieldController::class, 'update'])->name('fields.update');
        Route::delete('/{id}/fields/{fid}', [DynamicFormFieldController::class, 'destroy'])->name('fields.destroy');
        Route::post('/{id}/fields/reorder', [DynamicFormFieldController::class, 'reorder'])->name('fields.reorder');

        // Responses / Spreadsheet
        Route::get('/{id}/responses', [DynamicFormResponseController::class, 'index'])->name('responses.index');
        Route::get('/{id}/responses/{sid}', [DynamicFormResponseController::class, 'show'])->name('responses.show');
        Route::delete('/{id}/responses/{sid}', [DynamicFormResponseController::class, 'destroy'])->name('responses.destroy');
        Route::post('/{id}/responses/bulk-delete', [DynamicFormResponseController::class, 'bulkDelete'])->name('responses.bulk-delete');
        Route::get('/{id}/export', [DynamicFormResponseController::class, 'export'])->name('export');
    });
```

---

## 17. Frontend Component Planning

### 17.1 Component Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                    COMPONENT HIERARCHY                           │
└─────────────────────────────────────────────────────────────────┘

Admin Side:
├── FormBuilderPage
│   ├── FormBasicInfo (title, description, theme)
│   ├── FormCanvas
│   │   ├── SectionBlock
│   │   │   ├── FieldItem (draggable)
│   │   │   └── AddFieldButton
│   │   └── AddSectionButton
│   ├── FieldSidebar (palette of available field types)
│   ├── FieldPropertyPanel
│   │   ├── GeneralTab (label, placeholder, help)
│   │   ├── ValidationTab (required, rules)
│   │   ├── OptionsTab (for dropdown/radio/checkbox)
│   │   └── LogicTab (conditional, future)
│   └── FormSettingsPanel
│       ├── AccessTab (login, limit)
│       ├── DateTab (start, end)
│       ├── NotificationTab (emails)
│       └── ThemeTab (colors, fonts)
│
├── FormListPage
│   ├── FormCard (grid view)
│   ├── FormTable (list view)
│   ├── FilterBar
│   └── ActionButtons
│
├── ResponseSpreadsheetPage
│   ├── SpreadsheetHeader (column names, sort)
│   ├── SpreadsheetRow (data row)
│   ├── SpreadsheetPagination
│   ├── FilterPanel
│   ├── SearchBar
│   ├── ExportButton
│   └── ColumnToggle (show/hide columns)
│
└── ResponseDetailPage
    ├── SubmissionMeta (time, IP, device)
    ├── AnswerList (field → answer pairs)
    ├── FilePreview (uploaded files)
    └── ActionButtons (delete, flag)

Public Side:
├── FormPage
│   ├── FormHeader (title, description, image)
│   ├── FormBody
│   │   ├── SectionHeader
│   │   ├── FieldRenderer (dynamic per type)
│   │   │   ├── ShortTextField
│   │   │   ├── LongTextField
│   │   │   ├── EmailField
│   │   │   ├── PhoneField
│   │   │   ├── NumberField
│   │   │   ├── DateField
│   │   │   ├── TimeField
│   │   │   ├── DatetimeField
│   │   │   ├── DropdownField
│   │   │   ├── MultipleChoiceField
│   │   │   ├── CheckboxField
│   │   │   ├── FileUploadField
│   │   │   ├── ImageUploadField
│   │   │   ├── RatingField
│   │   │   ├── LinearScaleField
│   │   │   ├── YesNoField
│   │   │   ├── UrlField
│   │   │   ├── SectionDivider
│   │   │   ├── DescriptionText
│   │   │   └── HiddenField
│   │   └── ProgressIndicator
│   ├── FormFooter (submit button)
│   └── FormClosed (jika expired/closed)
│
└── ThankYouPage
    ├── ConfirmationMessage
    └── BackToHomeLink
```

### 17.2 JavaScript Libraries yang Direkomendasikan

| Library | Fungsi | Alasan |
|---------|--------|--------|
| Alpine.js | Reactive UI di admin | Lightweight, no build step, Laravel-friendly |
| SortableJS | Drag & drop fields | Vanilla JS, no dependencies |
| Flatpickr | Date/time picker | Lightweight, customizable |
| FilePond | File upload UI | Progressive upload, preview |
| Choices.js | Enhanced dropdown | Searchable, taggable select |
| Signature Pad | Signature input | Canvas-based, exportable |

---

## 18. Admin UI Planning

### 18.1 Halaman List Form

```
┌────────────────────────────────────────────────────────────────────┐
│ Dynamic Form Builder                                    [+ Buat Form] │
├────────────────────────────────────────────────────────────────────┤
│ [Search...] [Filter Status ▼] [Sort ▼]        View: [Grid] [List] │
├────────────────────────────────────────────────────────────────────┤
│                                                                    │
│ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐               │
│ │ 📋 Form A    │ │ 📋 Form B    │ │ 📋 Form C    │               │
│ │              │ │              │ │              │               │
│ │ Status: ●    │ │ Status: ●    │ │ Status: ●    │               │
│ │ Published    │ │ Draft        │ │ Closed       │               │
│ │              │ │              │ │              │               │
│ │ 125 respon   │ │ 0 respon     │ │ 89 respon    │               │
│ │ 20 Mei 2026  │ │ 18 Mei 2026  │ │ 10 Mei 2026  │               │
│ │              │ │              │ │              │               │
│ │ [Edit][...] │ │ [Edit][...] │ │ [View][...] │               │
│ └──────────────┘ └──────────────┘ └──────────────┘               │
│                                                                    │
└────────────────────────────────────────────────────────────────────┘
```

### 18.2 Halaman Form Builder

```
┌─────────────────────────────────────────────────────────────────────────┐
│ [← Back] Form Builder: "Pendaftaran Anggota Baru"    [Preview] [Save▼] │
├──────────┬──────────────────────────────────────────┬───────────────────┤
│          │                                          │                   │
│ FIELDS   │         FORM CANVAS                      │  PROPERTIES       │
│          │                                          │                   │
│ ──────── │  ┌────────────────────────────────────┐  │  Field: Nama      │
│ Text     │  │ Section 1: Data Pribadi         ×  │  │  ─────────────    │
│ ├ Short  │  │                                    │  │                   │
│ ├ Long   │  │  ┌─────────────────────────────┐   │  │  Label:           │
│ └ Email  │  │  │ ☰ Nama Lengkap        [×]  │   │  │  [Nama Lengkap  ] │
│          │  │  │   Short Text, Required      │   │  │                   │
│ Choice   │  │  └─────────────────────────────┘   │  │  Placeholder:     │
│ ├ Drop   │  │                                    │  │  [Masukkan nama  ]│
│ ├ Radio  │  │  ┌─────────────────────────────┐   │  │                   │
│ ├ Check  │  │  │ ☰ Email              [×]  │   │  │  Help Text:       │
│ └ Yes/No │  │  │   Email, Required           │   │  │  [              ] │
│          │  │  └─────────────────────────────┘   │  │                   │
│ Number   │  │                                    │  │  [✓] Required     │
│ ├ Number │  │  ┌─────────────────────────────┐   │  │  [ ] Hidden       │
│ ├ Rating │  │  │ ☰ Fakultas            [×]  │   │  │                   │
│ └ Scale  │  │  │   Dropdown, Required        │   │  │  Validation:      │
│          │  │  └─────────────────────────────┘   │  │  Max Length: [255]│
│ Date     │  │                                    │  │  Pattern: [     ] │
│ ├ Date   │  │  [+ Tambah Field]                  │  │                   │
│ ├ Time   │  │                                    │  │                   │
│ └ Both   │  └────────────────────────────────────┘  │                   │
│          │                                          │                   │
│ File     │  [+ Tambah Section]                      │                   │
│ ├ File   │                                          │                   │
│ └ Image  │                                          │                   │
│          │                                          │                   │
│ Layout   │                                          │                   │
│ ├ Divider│                                          │                   │
│ └ Text   │                                          │                   │
│          │                                          │                   │
└──────────┴──────────────────────────────────────────┴───────────────────┘
```

### 18.3 Halaman Spreadsheet Response

```
┌─────────────────────────────────────────────────────────────────────────┐
│ Responses: "Pendaftaran Anggota Baru"            125 responses          │
├─────────────────────────────────────────────────────────────────────────┤
│ [Search...] [Filter ▼] [Columns ▼]        [Export Excel] [Export CSV]   │
├─────┬──────────────┬────────────────┬───────────┬──────────┬────────────┤
│  #  │ Nama Lengkap │ Email          │ Fakultas  │ Waktu    │ Actions    │
├─────┼──────────────┼────────────────┼───────────┼──────────┼────────────┤
│  1  │ Ahmad Fauzi  │ ahmad@mail.com │ FTI       │ 20/05/26 │ [👁][🗑]  │
│  2  │ Siti Aminah  │ siti@mail.com  │ FEB       │ 20/05/26 │ [👁][🗑]  │
│  3  │ Budi Santoso │ budi@mail.com  │ FKIK      │ 19/05/26 │ [👁][🗑]  │
│  4  │ ...          │ ...            │ ...       │ ...      │ ...        │
├─────┴──────────────┴────────────────┴───────────┴──────────┴────────────┤
│ Showing 1-25 of 125      [← Previous] [1] [2] [3] [4] [5] [Next →]     │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 19. Public UI Planning

### 19.1 Layout Public Form

```
┌─────────────────────────────────────────────────────────────────┐
│                      [Header Image]                             │
│                                                                 │
│    ┌───────────────────────────────────────────────────────┐    │
│    │                                                       │    │
│    │   JUDUL FORM                                          │    │
│    │   Deskripsi form yang menjelaskan tujuan pengisian    │    │
│    │                                                       │    │
│    ├───────────────────────────────────────────────────────┤    │
│    │                                                       │    │
│    │   Section 1: Data Pribadi                             │    │
│    │   ─────────────────────────                           │    │
│    │                                                       │    │
│    │   Nama Lengkap *                                      │    │
│    │   ┌─────────────────────────────────────────────┐     │    │
│    │   │ Masukkan nama lengkap Anda                  │     │    │
│    │   └─────────────────────────────────────────────┘     │    │
│    │                                                       │    │
│    │   Email *                                             │    │
│    │   ┌─────────────────────────────────────────────┐     │    │
│    │   │ email@example.com                           │     │    │
│    │   └─────────────────────────────────────────────┘     │    │
│    │                                                       │    │
│    │   Fakultas *                                          │    │
│    │   ┌─────────────────────────────────────────────┐     │    │
│    │   │ Pilih fakultas                         [▼]  │     │    │
│    │   └─────────────────────────────────────────────┘     │    │
│    │                                                       │    │
│    │   Upload KTM *                                        │    │
│    │   ┌ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ┐     │    │
│    │   │  Drag & drop file atau klik untuk upload   │     │    │
│    │   │  Format: JPG, PNG (Max: 5MB)               │     │    │
│    │   └ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ┘     │    │
│    │                                                       │    │
│    │                              [Submit Formulir]        │    │
│    │                                                       │    │
│    └───────────────────────────────────────────────────────┘    │
│                                                                 │
│    Powered by LDK Syahid                                        │
└─────────────────────────────────────────────────────────────────┘
```

### 19.2 Theme Configuration

```json
{
  "themeConfig": {
    "primaryColor": "#0d9488",
    "backgroundColor": "#f8fafc",
    "cardBackground": "#ffffff",
    "textColor": "#1e293b",
    "fontFamily": "Inter, sans-serif",
    "borderRadius": "12px",
    "headerImage": null,
    "logoPosition": "center",
    "submitButtonText": "Submit Formulir",
    "submitButtonColor": "#0d9488",
    "progressBarColor": "#0d9488",
    "showProgressBar": true,
    "showFormTitle": true,
    "showRequiredIndicator": true
  }
}
```

### 19.3 Responsive Breakpoints

| Breakpoint | Layout | Behavior |
|-----------|--------|----------|
| Desktop (> 768px) | Card centered, max-width 720px | Full layout |
| Tablet (577-768px) | Card full width with padding | Adjusted spacing |
| Mobile (< 576px) | Full-width, minimal padding | Stacked layout, larger touch targets |

---

## 20. Future Enhancement List

### 20.1 Phase 2 Enhancements

| No | Feature | Prioritas | Kompleksitas |
|----|---------|-----------|-------------|
| 1 | Conditional Logic (show/hide field based on answer) | High | Medium |
| 2 | Multi-page Form (wizard style) | High | Medium |
| 3 | Form Template Library | Medium | Low |
| 4 | Calculated Fields (auto-compute) | Medium | Medium |
| 5 | Pre-fill from URL parameters | Medium | Low |
| 6 | Custom Thank You page per form | Medium | Low |
| 7 | Response Edit by User | Medium | Medium |
| 8 | Form Analytics Dashboard | Medium | Medium |

### 20.2 Phase 3 Enhancements

| No | Feature | Prioritas | Kompleksitas |
|----|---------|-----------|-------------|
| 9 | Payment Integration (Xendit) | High | High |
| 10 | Webhook on Submission | Medium | Medium |
| 11 | API Access for Submissions | Medium | Medium |
| 12 | Signature Pad Field | Low | Medium |
| 13 | QR Code for Form Access | Low | Low |
| 14 | Offline Form (PWA) | Low | High |
| 15 | Collaborative Editing (real-time) | Low | Very High |
| 16 | Form A/B Testing | Low | High |

### 20.3 Phase 4 Enhancements (Long-term)

| No | Feature | Deskripsi |
|----|---------|-----------|
| 17 | AI-powered Form Generation | Generate form dari natural language |
| 18 | Response Sentiment Analysis | Analisis sentimen dari text answers |
| 19 | Auto-categorization | Categorize submissions automatically |
| 20 | Workflow Integration | Trigger actions based on submissions |

---

## 21. Audit Log Planning

### 21.1 Events yang Di-log

| Action | Trigger | Data yang Disimpan |
|--------|---------|-------------------|
| form_created | Admin membuat form | Form title, field count |
| form_updated | Admin edit form | Changed fields (diff) |
| form_published | Admin publish form | Previous status |
| form_closed | Admin close form | Reason (optional) |
| form_deleted | Admin hapus form | Form snapshot |
| form_duplicated | Admin duplicate | Source form ID |
| field_added | Admin tambah field | Field type, label |
| field_updated | Admin edit field | Changed properties |
| field_deleted | Admin hapus field | Field snapshot |
| field_reordered | Admin reorder | Old/new order |
| submission_deleted | Admin hapus response | Submission ID |
| submission_exported | Admin export data | Format, filter criteria |
| collaborator_added | Admin tambah collaborator | User, permission level |
| collaborator_removed | Admin hapus collaborator | User |
| settings_updated | Admin ubah settings | Changed keys |

### 21.2 Log Retention

| Umur Log | Action |
|----------|--------|
| 0-3 bulan | Aktif, full detail |
| 3-12 bulan | Compressed, summary only |
| > 12 bulan | Archived to file, hapus dari DB |

### 21.3 Implementation Pattern

```php
// Trait untuk model yang perlu audit log
trait HasFormAuditLog
{
    public static function logAction(
        int $formID,
        string $action,
        ?string $description = null,
        ?array $payload = null
    ): void {
        TrFormAuditLog::create([
            'formID' => $formID,
            'userID' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'payload' => $payload ? json_encode($payload) : null,
            'ipAddress' => request()->ip(),
            'createdDate' => now(),
        ]);
    }
}
```

---

## 22. Versioning Form Strategy

### 22.1 Konsep Versioning

```
Permasalahan:
- Admin mengubah form setelah ada submission
- Field dihapus/ditambah setelah user sudah submit
- Bagaimana menjaga integritas data submission lama?

Solusi: Snapshot-based Versioning
```

### 22.2 Versioning Rules

| Perubahan | Impact | Action |
|-----------|--------|--------|
| Edit label/placeholder | Minor | No version bump, langsung update |
| Add new field | Minor | Version bump +1, field baru optional |
| Delete field | Major | Version bump +1, field di-soft delete |
| Change field type | Major | Version bump +1, create new field + soft delete old |
| Reorder fields | Minor | No version bump |
| Change validation | Minor | No version bump, apply ke submission baru |

### 22.3 Implementation

```php
// Di ms_form
// version column tracks current form version

// Di tr_form_submission
// formVersion column tracks which version user submitted against

// Saat display spreadsheet:
// 1. Load current fields (active)
// 2. Load historical fields (soft-deleted, untuk submission lama)
// 3. Map submission answers ke appropriate field version

// Saat admin menghapus field:
public function deleteField($fieldId)
{
    $field = MsFormField::findOrFail($fieldId);
    $form = MsForm::findOrFail($field->formID);

    // Soft delete (keep for historical data)
    $field->flagActive = 0;
    $field->editedDate = now();
    $field->save();

    // Bump form version
    $form->version += 1;
    $form->editedBy = auth()->user()->name;
    $form->editedDate = now();
    $form->save();

    // Log
    self::logAction($form->formID, 'field_deleted', "Field '{$field->label}' deleted");
}
```

### 22.4 Spreadsheet Display Logic

```php
// Menampilkan submission dari berbagai versi form
public function getSpreadsheetColumns($formID)
{
    // Active fields = current columns
    $activeFields = MsFormField::where('formID', $formID)
        ->where('flagActive', 1)
        ->orderBy('sortOrder')
        ->get();

    // Deleted fields yang masih punya data = historical columns
    $historicalFields = MsFormField::where('formID', $formID)
        ->where('flagActive', 0)
        ->whereExists(function ($query) {
            $query->select('formAnswerID')
                ->from('tr_form_answer')
                ->whereColumn('tr_form_answer.formFieldID', 'ms_form_field.formFieldID');
        })
        ->get();

    return [
        'active' => $activeFields,
        'historical' => $historicalFields, // Shown with indicator "deleted"
    ];
}
```

---

## 23. Draft & Publish Mechanism

### 23.1 Status Lifecycle

```
                    ┌─────────┐
         ┌─────────│  DRAFT  │◀─────────┐
         │         └────┬────┘          │
         │              │               │
         │    [Publish]  │    [Unpublish]│
         │              ▼               │
         │         ┌──────────┐         │
         │         │PUBLISHED │─────────┘
         │         └────┬─────┘
         │              │
         │     [Close]  │  [Auto-expire]
         │              ▼
         │         ┌──────────┐
         │         │  CLOSED  │
         │         └────┬─────┘
         │              │
         │   [Archive]  │
         │              ▼
         │         ┌──────────┐
         └────────▶│ ARCHIVED │
                   └──────────┘
```

### 23.2 Status Rules

| Status | Visibility | Editable | Accept Submission | Revertable To |
|--------|-----------|----------|-------------------|---------------|
| draft | Admin only | Full edit | No | - |
| published | Public | Limited edit* | Yes | draft |
| closed | Admin only | No (read-only) | No | published, draft |
| archived | Admin only | No (read-only) | No | draft |

*Limited edit saat published: hanya boleh edit label, help text, tambah field optional baru. Tidak boleh hapus/ubah tipe field yang sudah ada submission.

### 23.3 Implementation

```php
class MsForm extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_ARCHIVED = 'archived';

    // Status transition rules
    public static function allowedTransitions(): array
    {
        return [
            self::STATUS_DRAFT => [self::STATUS_PUBLISHED],
            self::STATUS_PUBLISHED => [self::STATUS_DRAFT, self::STATUS_CLOSED],
            self::STATUS_CLOSED => [self::STATUS_PUBLISHED, self::STATUS_DRAFT, self::STATUS_ARCHIVED],
            self::STATUS_ARCHIVED => [self::STATUS_DRAFT],
        ];
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::allowedTransitions()[$this->status] ?? [];
        return in_array($newStatus, $allowed);
    }

    public function publish(): void
    {
        if (!$this->canTransitionTo(self::STATUS_PUBLISHED)) {
            throw new \Exception("Cannot publish form from status: {$this->status}");
        }

        // Validate form has at least 1 input field
        $inputFieldCount = $this->fields()
            ->where('flagActive', 1)
            ->whereNotIn('fieldType', ['section_divider', 'description_text'])
            ->count();

        if ($inputFieldCount === 0) {
            throw new \Exception("Form must have at least 1 input field to publish");
        }

        $this->status = self::STATUS_PUBLISHED;
        $this->editedBy = auth()->user()->name;
        $this->editedDate = now();
        $this->save();

        self::logAction($this->formID, 'form_published');
    }

    public function close(): void
    {
        if (!$this->canTransitionTo(self::STATUS_CLOSED)) {
            throw new \Exception("Cannot close form from status: {$this->status}");
        }

        $this->status = self::STATUS_CLOSED;
        $this->editedBy = auth()->user()->name;
        $this->editedDate = now();
        $this->save();

        self::logAction($this->formID, 'form_closed');
    }

    public function isAcceptingSubmissions(): bool
    {
        if ($this->status !== self::STATUS_PUBLISHED) return false;
        if ($this->startDate && now()->lt($this->startDate)) return false;
        if ($this->endDate && now()->gt($this->endDate)) return false;
        if ($this->maxSubmission && $this->totalSubmission >= $this->maxSubmission) return false;
        return true;
    }
}
```

### 23.4 Auto-save Draft

```javascript
// Client-side auto-save untuk admin saat membuat form
const autoSave = {
    timer: null,
    interval: 30000, // 30 detik

    init() {
        this.timer = setInterval(() => this.save(), this.interval);
        window.addEventListener('beforeunload', () => this.save());
    },

    async save() {
        const formData = collectFormBuilderState();

        try {
            await fetch(`/admin/dynamic-form/${formId}/autosave`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(formData),
            });
            showSaveIndicator('Saved');
        } catch (e) {
            showSaveIndicator('Save failed');
        }
    }
};
```

---

## 24. Form Expired Mechanism

### 24.1 Expiration Types

| Type | Trigger | Behavior |
|------|---------|----------|
| Date-based | `endDate` tercapai | Form otomatis closed |
| Submission-based | `maxSubmission` tercapai | Form tetap published, reject submit baru |
| Manual | Admin klik "Close" | Immediate close |
| Scheduled | `startDate` belum tercapai | Form belum bisa diakses |

### 24.2 Implementation

```php
// Scheduled command untuk auto-close expired forms
// app/Console/Commands/CloseExpiredForms.php

class CloseExpiredForms extends Command
{
    protected $signature = 'forms:close-expired';
    protected $description = 'Close forms that have passed their end date';

    public function handle()
    {
        $expiredForms = MsForm::where('status', 'published')
            ->where('endDate', '<=', now())
            ->whereNotNull('endDate')
            ->get();

        foreach ($expiredForms as $form) {
            $form->status = MsForm::STATUS_CLOSED;
            $form->editedBy = 'SYSTEM';
            $form->editedDate = now();
            $form->save();

            MsForm::logAction($form->formID, 'form_auto_closed', 'Closed by system: end date reached');

            // Notify admin
            if ($form->notifyEmails) {
                $emails = json_decode($form->notifyEmails, true);
                // Dispatch notification job
            }

            $this->info("Form #{$form->formID} '{$form->title}' closed (expired)");
        }

        $this->info("Total: {$expiredForms->count()} forms closed.");
    }
}

// Schedule di app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->command('forms:close-expired')->hourly();
}
```

### 24.3 Public Form Access Check

```php
// Middleware atau controller check
public function show($slug)
{
    $form = MsForm::where('slug', $slug)->where('flagActive', 1)->firstOrFail();

    // Check various conditions
    if ($form->status !== MsForm::STATUS_PUBLISHED) {
        return view('landing-page.form.closed', ['form' => $form, 'reason' => 'not_published']);
    }

    if ($form->startDate && now()->lt($form->startDate)) {
        return view('landing-page.form.closed', [
            'form' => $form,
            'reason' => 'not_started',
            'startDate' => $form->startDate
        ]);
    }

    if ($form->endDate && now()->gt($form->endDate)) {
        return view('landing-page.form.closed', ['form' => $form, 'reason' => 'expired']);
    }

    if ($form->maxSubmission && $form->totalSubmission >= $form->maxSubmission) {
        return view('landing-page.form.closed', ['form' => $form, 'reason' => 'full']);
    }

    // Form is accessible
    $fields = MsFormField::where('formID', $form->formID)
        ->where('flagActive', 1)
        ->orderBy('sortOrder')
        ->get();

    return view('landing-page.form.show', compact('form', 'fields'));
}
```

---

## 25. Anti Spam Strategy

### 25.1 Multi-Layer Anti-Spam

```
┌─────────────────────────────────────────────────────────────────┐
│              ANTI-SPAM DEFENSE LAYERS                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ Layer 1: Honeypot (Invisible to humans)                         │
│ ├── Hidden input field "website_url"                            │
│ ├── CSS-hidden field "company_name"                             │
│ └── If filled → silently reject (fake success response)        │
│                                                                 │
│ Layer 2: Time-based Detection                                   │
│ ├── Record form load timestamp (encrypted)                     │
│ ├── If submission < 3 seconds → flag as bot                    │
│ └── If submission < 1 second → silent reject                   │
│                                                                 │
│ Layer 3: JavaScript Token                                       │
│ ├── Generate unique token on page load via JS                  │
│ ├── Token rotates every 5 minutes                              │
│ └── If no token / invalid token → reject                       │
│     (Bots tanpa JS engine tidak bisa generate token)           │
│                                                                 │
│ Layer 4: Rate Limiting (per IP)                                 │
│ ├── Max 5 submissions per 10 minutes per IP                    │
│ ├── Max 20 submissions per hour per IP                         │
│ └── Configurable per form                                      │
│                                                                 │
│ Layer 5: Content Analysis (Optional)                            │
│ ├── Check for excessive URLs in text fields                    │
│ ├── Check for repeated identical submissions                   │
│ └── Check for known spam patterns                              │
│                                                                 │
│ Layer 6: Manual Review                                          │
│ ├── Admin can flag submission as spam                          │
│ ├── Flagged submissions excluded from export                   │
│ └── Pattern learning from flagged submissions                  │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 25.2 JavaScript Token Implementation

```javascript
// Public form page - generate anti-spam token
(function() {
    const generateToken = () => {
        const timestamp = Date.now();
        const random = Math.random().toString(36).substring(2);
        const token = btoa(`${timestamp}:${random}:${document.title.length}`);
        document.getElementById('_form_token').value = token;
    };

    // Generate on load
    generateToken();

    // Regenerate every 5 minutes
    setInterval(generateToken, 300000);
})();
```

```php
// Server-side token validation
public function validateSpamToken(Request $request): bool
{
    $token = $request->input('_form_token');

    if (empty($token)) {
        return false; // No JS = likely bot
    }

    try {
        $decoded = base64_decode($token);
        $parts = explode(':', $decoded);

        if (count($parts) !== 3) return false;

        $timestamp = (int) $parts[0];
        $age = (time() * 1000) - $timestamp;

        // Token harus antara 3 detik dan 30 menit
        if ($age < 3000 || $age > 1800000) return false;

        return true;
    } catch (\Exception $e) {
        return false;
    }
}
```

---

## 26. Rate Limiting Strategy

### 26.1 Rate Limit Configuration

| Endpoint | Limit | Window | Scope |
|----------|-------|--------|-------|
| GET /form/{slug} | 60 requests | 1 minute | Per IP |
| POST /form/{slug}/submit | 5 requests | 10 minutes | Per IP |
| POST /form/{slug}/upload-temp | 10 requests | 1 minute | Per IP |
| Admin API endpoints | 120 requests | 1 minute | Per User |
| Export endpoint | 3 requests | 5 minutes | Per User |

### 26.2 Implementation

```php
// app/Http/Kernel.php - Register custom rate limiters
protected function configureRateLimiting()
{
    // Form submission rate limiter
    RateLimiter::for('form-submit', function (Request $request) {
        return Limit::perMinutes(10, 5)->by($request->ip());
    });

    // Form view rate limiter
    RateLimiter::for('form-view', function (Request $request) {
        return Limit::perMinute(60)->by($request->ip());
    });

    // File upload rate limiter
    RateLimiter::for('form-upload', function (Request $request) {
        return Limit::perMinute(10)->by($request->ip());
    });

    // Export rate limiter (per authenticated user)
    RateLimiter::for('form-export', function (Request $request) {
        return Limit::perMinutes(5, 3)->by($request->user()->id);
    });
}
```

### 26.3 Custom Rate Limit per Form

```php
// Admin bisa set custom rate limit per form via settings
// ms_form_setting:
// settingKey: 'rate_limit_submit'
// settingValue: '{"max": 3, "window": 15}' // 3 per 15 menit

public function getFormRateLimit(MsForm $form): array
{
    $setting = MsFormSetting::where('formID', $form->formID)
        ->where('settingKey', 'rate_limit_submit')
        ->first();

    if ($setting) {
        return json_decode($setting->settingValue, true);
    }

    // Default
    return ['max' => 5, 'window' => 10];
}
```

---

## 27. Performance Consideration

### 27.1 Performance Targets

| Metric | Target | Measurement |
|--------|--------|-------------|
| Form page load (TTFB) | < 300ms | Server response time |
| Form page complete load | < 2s | Full page with assets |
| Form submission response | < 500ms | POST response time |
| Spreadsheet page load | < 1s | With 25 rows |
| Export 1000 rows | < 10s | Background job |
| Export 10000 rows | < 60s | Background job |
| Search across submissions | < 500ms | JSON_EXTRACT query |

### 27.2 Optimization Strategies

```
┌─────────────────────────────────────────────────────────────────┐
│                 PERFORMANCE OPTIMIZATIONS                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ 1. DATABASE LEVEL                                               │
│    ├── Proper indexing on frequently queried columns            │
│    ├── JSON virtual generated columns for hot queries           │
│    ├── Denormalized totalSubmission counter                     │
│    ├── Pagination (never load all submissions)                  │
│    └── Query explain analysis for slow queries                  │
│                                                                 │
│ 2. APPLICATION LEVEL                                            │
│    ├── Eager loading relationships (prevent N+1)               │
│    ├── Cache form definition (5 min TTL)                       │
│    ├── Cache field list per form (5 min TTL)                   │
│    ├── Queue heavy operations (export, notification)           │
│    └── Chunked processing for large datasets                   │
│                                                                 │
│ 3. FRONTEND LEVEL                                               │
│    ├── Lazy load form fields (render visible first)            │
│    ├── Debounce search input (300ms)                           │
│    ├── Virtual scrolling for spreadsheet (if >100 rows)        │
│    ├── Compress and minify JS/CSS                              │
│    └── Progressive file upload (chunked)                       │
│                                                                 │
│ 4. INFRASTRUCTURE LEVEL                                         │
│    ├── CDN for static assets                                   │
│    ├── Gzip/Brotli compression                                 │
│    ├── HTTP/2 multiplexing                                     │
│    └── Database connection pooling                             │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### 27.3 N+1 Prevention

```php
// BAD: N+1 query
$submissions = TrFormSubmission::where('formID', $formID)->get();
foreach ($submissions as $sub) {
    $answers = $sub->answers; // Query per submission!
}

// GOOD: Eager loading
$submissions = TrFormSubmission::where('formID', $formID)
    ->with('answers')
    ->paginate(25);

// BEST: Menggunakan answersJson (no additional query)
$submissions = TrFormSubmission::where('formID', $formID)
    ->select(['formSubmissionID', 'respondentName', 'respondentEmail', 'answersJson', 'submittedAt'])
    ->paginate(25);
// Parse JSON di application layer, bukan per-row query
```

---

## 28. Queue/Background Job Recommendation

### 28.1 Jobs yang Perlu Queue

| Job | Trigger | Priority | Timeout |
|-----|---------|----------|---------|
| ProcessFormSubmission | User submit form | High | 30s |
| SendSubmissionNotification | After submission saved | Medium | 60s |
| ExportFormData | Admin request export | Low | 300s |
| MoveFileToPermanent | After submission saved | High | 120s |
| CleanupTempFiles | Scheduled (hourly) | Low | 600s |
| SendFormExpiredNotification | Scheduled (hourly) | Low | 30s |
| GenerateFormAnalytics | Scheduled (daily) | Low | 300s |

### 28.2 Job Implementation

```php
// app/Jobs/ProcessFormSubmission.php
class ProcessFormSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;
    public string $queue = 'form-submissions';

    private TrFormSubmission $submission;

    public function __construct(TrFormSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function handle()
    {
        // 1. Move temp files to permanent storage
        $this->moveFilesToPermanent();

        // 2. Update submission counter
        MsForm::where('formID', $this->submission->formID)
            ->increment('totalSubmission');

        // 3. Dispatch notification
        SendSubmissionNotification::dispatch($this->submission);

        // 4. Clear relevant caches
        Cache::forget("form_submission_count_{$this->submission->formID}");
        Cache::forget("form_spreadsheet_{$this->submission->formID}_page_1");
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Form submission processing failed', [
            'submissionID' => $this->submission->formSubmissionID,
            'error' => $exception->getMessage(),
        ]);
    }
}
```

```php
// app/Jobs/ExportFormData.php
class ExportFormData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;
    public int $timeout = 300;
    public string $queue = 'form-exports';

    private int $formID;
    private int $userID;
    private string $format;
    private array $filters;

    public function __construct(int $formID, int $userID, string $format, array $filters = [])
    {
        $this->formID = $formID;
        $this->userID = $userID;
        $this->format = $format;
        $this->filters = $filters;
    }

    public function handle()
    {
        $form = MsForm::findOrFail($this->formID);
        $fields = MsFormField::where('formID', $this->formID)
            ->where('flagActive', 1)
            ->orderBy('sortOrder')
            ->get();

        $filename = "form_{$form->slug}_" . date('Y-m-d_His');

        // Process in chunks
        $query = TrFormSubmission::where('formID', $this->formID)
            ->where('flagValid', 1);

        // Apply filters
        // ...

        switch ($this->format) {
            case 'xlsx':
                $path = $this->exportExcel($query, $fields, $filename);
                break;
            case 'csv':
                $path = $this->exportCsv($query, $fields, $filename);
                break;
        }

        // Notify user that export is ready
        $user = User::find($this->userID);
        // Send notification with download link

        // Log audit
        MsForm::logAction($this->formID, 'submission_exported', "Exported as {$this->format}");
    }

    private function exportExcel($query, $fields, $filename): string
    {
        // Chunk processing to avoid memory issues
        $path = storage_path("app/exports/{$filename}.xlsx");

        $query->chunk(500, function ($submissions) use ($fields, &$rows) {
            foreach ($submissions as $submission) {
                $answers = json_decode($submission->answersJson, true);
                $row = ['submittedAt' => $submission->submittedAt];

                foreach ($fields as $field) {
                    $key = 'field_' . $field->formFieldID;
                    $row[$field->label] = $answers[$key] ?? '';
                }

                $rows[] = $row;
            }
        });

        // Write to file using PhpSpreadsheet
        // ...

        return $path;
    }
}
```

### 28.3 Queue Configuration

```php
// config/queue.php
'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
    ],
],

// Queue priority order
// php artisan queue:work --queue=form-submissions,form-exports,default
```

---

## 29. Dynamic Schema vs JSON Strategy

### 29.1 Perbandingan Mendalam

#### Option A: Dynamic Columns (ALTER TABLE per form)

```sql
-- Saat admin buat form "Pendaftaran"
CREATE TABLE form_data_pendaftaran (
    id BIGINT PRIMARY KEY,
    field_nama VARCHAR(255),
    field_email VARCHAR(255),
    field_fakultas VARCHAR(100),
    submitted_at DATETIME
);
```

**Pros:**
- Query langsung dengan WHERE clause standard
- Indexing per column
- JOIN mudah
- Native SQL filtering dan sorting

**Cons:**
- ALTER TABLE lock table (slow pada table besar)
- Ratusan form = ratusan table
- Migration nightmare
- Tidak bisa reuse code (setiap table beda struktur)
- MySQL table limit consideration

**Verdict: ❌ REJECTED** - Tidak scalable, maintenance cost terlalu tinggi.

---

#### Option B: EAV (Entity-Attribute-Value)

```sql
-- Single table untuk semua answers
CREATE TABLE form_answers (
    id BIGINT PRIMARY KEY,
    submission_id BIGINT,
    field_id BIGINT,
    value_text TEXT,
    value_number DECIMAL,
    value_date DATE
);
```

**Pros:**
- Sangat fleksibel
- Single table untuk semua data
- Bisa filter per field

**Cons:**
- Query sangat kompleks (multiple JOINs / PIVOT)
- Performance menurun drastis saat data besar
- Sulit export ke format tabular
- Row count meledak (1 submission = N rows dimana N = jumlah field)

**Verdict: ⚠️ PARTIAL USE** - Digunakan sebagai metadata index (`tr_form_answer`), bukan primary storage.

---

#### Option C: Pure JSON Storage

```sql
-- Semua answers dalam 1 JSON column
CREATE TABLE form_submissions (
    id BIGINT PRIMARY KEY,
    form_id BIGINT,
    answers JSON, -- {"field_1": "Ahmad", "field_2": "ahmad@mail.com", ...}
    submitted_at DATETIME
);
```

**Pros:**
- Sangat simple
- Tidak perlu ALTER TABLE
- Flexible schema
- Fast write (single INSERT)
- Easy to understand

**Cons:**
- Filtering membutuhkan JSON_EXTRACT (slower)
- Tidak bisa traditional index pada JSON values
- Full table scan untuk search

**Verdict: ✅ PRIMARY STORAGE** - Digunakan sebagai storage utama dengan optimization.

---

#### Option D: Hybrid (JSON Primary + EAV Index) ← RECOMMENDED

```sql
-- Primary storage: JSON (fast write, complete data)
tr_form_submission:
    answersJson JSON -- Full data

-- Secondary index: EAV (fast read/filter untuk specific queries)
tr_form_answer:
    formFieldID BIGINT
    answerValue TEXT     -- For text search
    answerNumeric DECIMAL -- For numeric filtering
    answerDate DATE      -- For date filtering
```

**Pros:**
- Fast write (single JSON insert)
- Complete data integrity (all answers in one place)
- Searchable via EAV index
- Sortable via typed columns (numeric, date)
- Export dari JSON (complete, no JOINs needed)
- Filter dari EAV (indexed, fast)

**Cons:**
- Data duplication (JSON + EAV)
- Slightly more complex write (2 inserts per submission)
- Need to keep JSON and EAV in sync

**Verdict: ✅✅ SELECTED** - Best balance of flexibility, performance, dan maintainability.

### 29.2 Justifikasi Teknis

```
Skenario: Form dengan 10 field, 10,000 submissions

┌────────────────────────┬────────────────┬──────────────────┐
│ Operation              │ Pure JSON      │ Hybrid           │
├────────────────────────┼────────────────┼──────────────────┤
│ INSERT submission      │ 1 query        │ 1 + N queries*   │
│ SELECT all for export  │ 1 query (fast) │ 1 query (fast)   │
│ FILTER by 1 field      │ Full scan**    │ Index scan       │
│ SORT by numeric field  │ JSON sort***   │ Index sort       │
│ Full text search       │ JSON scan      │ LIKE on index    │
│ Spreadsheet view       │ 1 query        │ 1 query (JSON)   │
│ Storage per submission │ ~1 row         │ ~1 + N rows      │
└────────────────────────┴────────────────┴──────────────────┘

*  N = number of indexed fields (not all fields need EAV entry)
** Full scan mitigated by MySQL JSON indexing (generated columns)
*** JSON sort possible but slower than native sort
```

### 29.3 Strategi Sinkronisasi

```php
// Saat submission masuk, simpan di kedua tempat
public function saveSubmission(MsForm $form, array $answers): TrFormSubmission
{
    return DB::transaction(function () use ($form, $answers) {
        // 1. Insert submission dengan full JSON
        $submission = TrFormSubmission::create([
            'formID' => $form->formID,
            'formVersion' => $form->version,
            'answersJson' => json_encode($answers),
            'submittedAt' => now(),
            // ... other fields
        ]);

        // 2. Insert EAV records hanya untuk searchable/filterable fields
        $indexableFields = MsFormField::where('formID', $form->formID)
            ->where('flagActive', 1)
            ->whereNotIn('fieldType', ['section_divider', 'description_text', 'hidden_field'])
            ->get();

        $answerRecords = [];
        foreach ($indexableFields as $field) {
            $key = 'field_' . $field->formFieldID;
            $value = $answers[$key] ?? null;

            if ($value === null) continue;

            $record = [
                'formSubmissionID' => $submission->formSubmissionID,
                'formFieldID' => $field->formFieldID,
                'answerValue' => is_array($value) ? json_encode($value) : (string) $value,
                'answerNumeric' => is_numeric($value) ? (float) $value : null,
                'answerDate' => $this->parseDate($value, $field->fieldType),
                'createdDate' => now(),
            ];

            $answerRecords[] = $record;
        }

        // Bulk insert for performance
        TrFormAnswer::insert($answerRecords);

        return $submission;
    });
}
```

---

## 30. Spreadsheet Architecture Recommendation

### 30.1 Architecture Decision

**Pendekatan: Server-side rendered table dengan AJAX pagination dan filtering**

Alasan:
1. Tidak memerlukan heavy JavaScript framework (React/Vue)
2. Konsisten dengan existing project pattern (Blade + jQuery/AJAX)
3. Performance baik dengan server-side processing
4. SEO tidak diperlukan (admin only)
5. Export langsung dari server (no client-side processing)

### 30.2 Spreadsheet Features

| Feature | Implementation | Notes |
|---------|---------------|-------|
| Column Display | Dynamic from form fields | Show/hide toggle |
| Sorting | Server-side ORDER BY | Via JSON_EXTRACT or EAV |
| Filtering | Server-side WHERE | Per-column filter |
| Search | Server-side LIKE | Global search across all fields |
| Pagination | Server-side LIMIT/OFFSET | 25 rows default |
| Row Selection | Client-side checkbox | For bulk operations |
| Column Resize | CSS resize | Saved to localStorage |
| Frozen Columns | CSS sticky | First 2 columns (# and name) |
| Cell Truncation | CSS text-overflow | Expand on click |
| Export | Background job | Excel, CSV, PDF |

### 30.3 Data Flow

```
┌──────────────────────────────────────────────────────────────────┐
│                    SPREADSHEET DATA FLOW                          │
└──────────────────────────────────────────────────────────────────┘

User Action          →    AJAX Request       →    Server Process
─────────────────────────────────────────────────────────────────────
Page Load            →    GET ?page=1        →    Query + Render HTML
Click Sort           →    GET ?sort=field_3  →    ORDER BY JSON_EXTRACT
Type Search          →    GET ?search=ahmad  →    WHERE LIKE (debounced)
Select Filter        →    GET ?filter[f3]=X  →    WHERE JSON_EXTRACT = X
Click Page           →    GET ?page=3        →    OFFSET calculation
Toggle Column        →    (client-side only) →    Show/hide via CSS
Click Export         →    POST /export       →    Dispatch Job → Download
Click Delete         →    DELETE /responses/5→    Soft delete + refresh
Bulk Delete          →    POST /bulk-delete  →    Delete selected IDs
```

### 30.4 Server Response Format

```php
// Response for AJAX table reload
public function index(Request $request, $formID)
{
    $form = MsForm::findOrFail($formID);
    $fields = MsFormField::where('formID', $formID)
        ->where('flagActive', 1)
        ->orderBy('sortOrder')
        ->get();

    $submissions = $this->getSpreadsheetData($formID, $request);

    if ($request->ajax()) {
        return response()->json([
            'tableBody' => view('admin-page.dynamic-form.responses.partials.table-body', [
                'submissions' => $submissions,
                'fields' => $fields,
            ])->render(),
            'pagination' => $submissions->links()->render(),
            'total' => $submissions->total(),
            'from' => $submissions->firstItem(),
            'to' => $submissions->lastItem(),
        ]);
    }

    return view('admin-page.dynamic-form.responses.index', compact('form', 'fields', 'submissions'));
}
```

### 30.5 Scalability untuk Dynamic Fields

```php
// Problem: Bagaimana render table yang field-nya berbeda tiap form?
// Solution: Generic table renderer yang membaca field config

// Blade template pattern
@foreach ($fields as $field)
    <th data-field-id="{{ $field->formFieldID }}"
        data-field-type="{{ $field->fieldType }}"
        class="spreadsheet-header sortable">
        {{ $field->label }}
        <span class="sort-icon"></span>
    </th>
@endforeach

// Row rendering
@foreach ($submissions as $submission)
    @php $answers = json_decode($submission->answersJson, true); @endphp
    <tr>
        <td>{{ $loop->iteration + ($submissions->currentPage() - 1) * $submissions->perPage() }}</td>
        @foreach ($fields as $field)
            <td class="cell-{{ $field->fieldType }}">
                @include('admin-page.dynamic-form.responses.partials.cell-renderer', [
                    'field' => $field,
                    'value' => $answers['field_' . $field->formFieldID] ?? null,
                ])
            </td>
        @endforeach
        <td class="actions">
            <a href="{{ route('admin.dynamic-form.responses.show', [$form->formID, $submission->formSubmissionID]) }}">
                View
            </a>
        </td>
    </tr>
@endforeach
```

---

## 31. Notification System Recommendation

### 31.1 Notification Channels

| Event | Channel | Recipient | Priority |
|-------|---------|-----------|----------|
| New Submission | Email | Form notifyEmails | Medium |
| New Submission | WhatsApp (Fonnte) | Form owner | High |
| Form Expired | Email | Form creator | Low |
| Export Ready | In-app notification | Requesting admin | Medium |
| Submission Limit 80% | Email | Form creator | Medium |
| Spam Detected | In-app notification | Admin | Low |

### 31.2 Email Notification Template

```php
// app/Mail/NewFormSubmission.php
class NewFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public MsForm $form;
    public TrFormSubmission $submission;

    public function build()
    {
        return $this->subject("Form Submission Baru: {$this->form->title}")
            ->view('emails.form-submission')
            ->with([
                'form' => $this->form,
                'submission' => $this->submission,
                'answers' => json_decode($this->submission->answersJson, true),
                'viewUrl' => route('admin.dynamic-form.responses.show', [
                    $this->form->formID,
                    $this->submission->formSubmissionID
                ]),
            ]);
    }
}
```

### 31.3 WhatsApp Notification (Fonnte)

```php
// Menggunakan existing Fonnte service
class FormNotificationService
{
    public function sendWhatsAppNotification(MsForm $form, TrFormSubmission $submission): void
    {
        $answers = json_decode($submission->answersJson, true);

        // Build message
        $message = "*Form Submission Baru*\n";
        $message .= "Form: {$form->title}\n";
        $message .= "Waktu: " . $submission->submittedAt->format('d/m/Y H:i') . "\n";
        $message .= "─────────────\n";

        // Include first 5 fields
        $fields = MsFormField::where('formID', $form->formID)
            ->where('flagActive', 1)
            ->orderBy('sortOrder')
            ->take(5)
            ->get();

        foreach ($fields as $field) {
            $key = 'field_' . $field->formFieldID;
            $value = $answers[$key] ?? '-';
            if (is_array($value)) $value = implode(', ', $value);
            $message .= "{$field->label}: {$value}\n";
        }

        $message .= "\nLihat detail di admin panel.";

        // Send via Fonnte
        $fonnte = new Fonnte();
        $fonnte->sendMessage($targetPhone, $message);
    }
}
```

---

## 32. Access Permission Structure

### 32.1 Role Access Matrix

| Permission | Superadmin | HelperAdmin | HelperCelsyahid | HelperMedia | HelperSPAM | HelperLetter | HelperEventMart | User |
|------------|:----------:|:-----------:|:---------------:|:-----------:|:-----------:|:------------:|:---------------:|:----:|
| View form list | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Create form | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Edit own form | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Edit any form | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Delete own form | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Delete any form | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Bulk delete | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Publish form | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| View responses | ✅ | ✅ | ✅* | ✅* | ✅* | ✅* | ✅* | ❌ |
| Export data | ✅ | ✅ | ✅* | ✅* | ✅* | ✅* | ✅* | ❌ |
| Delete responses | ✅ | ✅ | ✅* | ✅* | ✅* | ✅* | ✅* | ❌ |
| Manage collaborators | ✅ | ✅ | ✅* | ✅* | ✅* | ✅* | ✅* | ❌ |
| View audit log | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| System settings | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Submit public form | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

> *\* Hanya untuk form milik sendiri atau form dimana user menjadi collaborator*

### 32.2 Ownership & Collaboration

```php
// Form ownership check
class FormPolicy
{
    public function update(User $user, MsForm $form): bool
    {
        // Superadmin & HelperAdmin bisa edit semua
        if ($user->hasAnyRole(['Superadmin', 'HelperAdmin'])) {
            return true;
        }

        // Owner bisa edit
        if ($form->createdBy === $user->name) {
            return true;
        }

        // Collaborator dengan permission edit/manage
        return MapFormCollaborator::where('formID', $form->formID)
            ->where('userID', $user->id)
            ->whereIn('permission', ['edit', 'manage'])
            ->exists();
    }

    public function viewResponses(User $user, MsForm $form): bool
    {
        if ($user->hasAnyRole(['Superadmin', 'HelperAdmin'])) {
            return true;
        }

        if ($form->createdBy === $user->name) {
            return true;
        }

        return MapFormCollaborator::where('formID', $form->formID)
            ->where('userID', $user->id)
            ->exists();
    }

    public function delete(User $user, MsForm $form): bool
    {
        if ($user->hasRole('Superadmin')) {
            return true;
        }

        // Only owner can delete (non-superadmin)
        return $form->createdBy === $user->name;
    }
}
```

### 32.3 Middleware Implementation

```php
// routes/web.php
Route::middleware([
    'auth',
    'role:Superadmin|HelperAdmin|HelperCelsyahid|HelperMedia|HelperSPAM|HelperLetter|HelperEventMart'
])
->prefix('/admin/dynamic-form')
->name('admin.dynamic-form.')
->group(function () {
    // Routes here
});

// Note: role "user" is explicitly EXCLUDED from the middleware list
// This ensures only admin-level roles can access form management
```

---

## 33. Recommended Folder Structure

### 33.1 Backend Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DynamicFormController.php          # Form CRUD
│   │   ├── DynamicFormFieldController.php     # Field management (AJAX)
│   │   ├── DynamicFormResponseController.php  # Responses/spreadsheet
│   │   └── PublicFormController.php           # Public form render & submit
│   │
│   ├── Requests/
│   │   ├── StoreFormRequest.php               # Form creation validation
│   │   ├── UpdateFormRequest.php              # Form update validation
│   │   └── SubmitFormRequest.php              # Public submission validation
│   │
│   └── Middleware/
│       ├── CheckFormAccess.php                # Form ownership/collaborator check
│       └── FormRateLimit.php                  # Custom per-form rate limiting
│
├── Models/
│   ├── MsForm.php                             # Form master model
│   ├── MsFormField.php                        # Form field model
│   ├── MsFormSection.php                      # Form section model
│   ├── MsFormSetting.php                      # Form settings model
│   ├── TrFormSubmission.php                   # Submission model
│   ├── TrFormAnswer.php                       # Answer index model
│   ├── TrFormFile.php                         # File upload model
│   ├── TrFormAuditLog.php                     # Audit log model
│   └── MapFormCollaborator.php                # Collaborator mapping model
│
├── Services/
│   ├── FormBuilderService.php                 # Form creation/update logic
│   ├── FormSubmissionService.php              # Submission processing
│   ├── FormExportService.php                  # Export logic (Excel/CSV)
│   ├── FormValidationBuilder.php              # Dynamic validation rules
│   ├── FormNotificationService.php            # Notification dispatch
│   └── FormFileService.php                    # File upload/move/delete
│
├── Jobs/
│   ├── ProcessFormSubmission.php              # Post-submission processing
│   ├── ExportFormData.php                     # Background export
│   ├── SendSubmissionNotification.php         # Email/WA notification
│   ├── MoveFormFilesToPermanent.php           # Move temp → GDrive
│   └── CleanupTempFormFiles.php               # Cleanup orphan temp files
│
├── Events/
│   ├── FormSubmitted.php                      # Event: form submitted
│   ├── FormPublished.php                      # Event: form published
│   └── FormExportCompleted.php                # Event: export done
│
├── Listeners/
│   ├── NotifyOnFormSubmission.php             # Listen: FormSubmitted
│   ├── LogFormPublished.php                   # Listen: FormPublished
│   └── NotifyExportReady.php                  # Listen: FormExportCompleted
│
├── Policies/
│   └── FormPolicy.php                         # Authorization logic
│
└── Traits/
    └── HasFormAuditLog.php                    # Audit logging trait
```

### 33.2 Frontend Structure (Views)

```
resources/views/
├── admin-page/
│   └── dynamic-form/
│       ├── index.blade.php                    # Form list page
│       ├── create.blade.php                   # Form builder (create)
│       ├── edit.blade.php                     # Form builder (edit)
│       ├── show.blade.php                     # Form detail/preview
│       ├── responses/
│       │   ├── index.blade.php                # Spreadsheet view
│       │   ├── show.blade.php                 # Single submission detail
│       │   └── partials/
│       │       ├── table-body.blade.php       # AJAX table body
│       │       ├── cell-renderer.blade.php    # Dynamic cell renderer
│       │       └── filter-panel.blade.php     # Filter panel
│       └── components/
│           ├── _builder-styles.blade.php      # Form builder CSS
│           ├── _builder-scripts.blade.php     # Form builder JS
│           ├── _spreadsheet-styles.blade.php  # Spreadsheet CSS
│           └── _spreadsheet-scripts.blade.php # Spreadsheet JS
│
└── landing-page/
    └── form/
        ├── show.blade.php                     # Public form page
        ├── closed.blade.php                   # Form closed/expired page
        ├── thankyou.blade.php                 # Thank you page
        ├── components/
        │   ├── _form-styles.blade.php         # Public form CSS
        │   ├── _form-scripts.blade.php        # Public form JS
        │   └── fields/                        # Field type partials
        │       ├── _short-text.blade.php
        │       ├── _long-text.blade.php
        │       ├── _email.blade.php
        │       ├── _phone.blade.php
        │       ├── _number.blade.php
        │       ├── _date.blade.php
        │       ├── _time.blade.php
        │       ├── _datetime.blade.php
        │       ├── _dropdown.blade.php
        │       ├── _multiple-choice.blade.php
        │       ├── _checkbox.blade.php
        │       ├── _file-upload.blade.php
        │       ├── _image-upload.blade.php
        │       ├── _rating.blade.php
        │       ├── _linear-scale.blade.php
        │       ├── _yes-no.blade.php
        │       ├── _url.blade.php
        │       ├── _section-divider.blade.php
        │       ├── _description-text.blade.php
        │       └── _hidden-field.blade.php
        └── layouts/
            └── form-layout.blade.php          # Base layout for public forms
```

### 33.3 Database Migration Structure

```
database/migrations/
├── 2026_05_20_000001_create_ms_form_table.php
├── 2026_05_20_000002_create_ms_form_section_table.php
├── 2026_05_20_000003_create_ms_form_field_table.php
├── 2026_05_20_000004_create_ms_form_setting_table.php
├── 2026_05_20_000005_create_tr_form_submission_table.php
├── 2026_05_20_000006_create_tr_form_answer_table.php
├── 2026_05_20_000007_create_tr_form_file_table.php
├── 2026_05_20_000008_create_tr_form_audit_log_table.php
└── 2026_05_20_000009_create_map_form_collaborator_table.php
```

---

## 34. Naming Convention Rules

### 34.1 Database Naming

| Element | Convention | Contoh |
|---------|-----------|--------|
| Table name | snake_case dengan prefix | `ms_form`, `tr_form_submission` |
| Table prefix master | `ms_` | `ms_form`, `ms_form_field` |
| Table prefix transaction | `tr_` | `tr_form_submission`, `tr_form_answer` |
| Table prefix mapping | `map_` | `map_form_collaborator` |
| Column name | camelCase | `formID`, `fieldType`, `sortOrder` |
| Primary key | `<tableName>ID` | `formID`, `formFieldID`, `formSubmissionID` |
| Foreign key | Sama dengan PK yang direferensi | `formID` di `ms_form_field` |
| Boolean column | `flag<Name>` atau `is<Name>` | `flagActive`, `isRequired` |
| Timestamp column | `<action>Date` atau `<action>At` | `createdDate`, `submittedAt` |
| JSON column | Descriptive name + suffix jika perlu | `answersJson`, `themeConfig`, `options` |
| Index name | `idx_<table>_<columns>` | `idx_submission_form` |
| Unique constraint | `uniq_<table>_<columns>` | `uniq_form_slug` |

### 34.2 PHP Naming

| Element | Convention | Contoh |
|---------|-----------|--------|
| Model class | PascalCase dengan prefix | `MsForm`, `TrFormSubmission` |
| Controller class | PascalCase + Controller | `DynamicFormController` |
| Service class | PascalCase + Service | `FormBuilderService` |
| Job class | PascalCase (verb-based) | `ProcessFormSubmission` |
| Event class | PascalCase (past tense) | `FormSubmitted` |
| Listener class | PascalCase (verb-based) | `NotifyOnFormSubmission` |
| Trait | PascalCase (Has/Is prefix) | `HasFormAuditLog` |
| Policy | PascalCase + Policy | `FormPolicy` |
| Request | PascalCase + Request | `StoreFormRequest` |
| Method | camelCase | `getSpreadsheetData()` |
| Variable | camelCase | `$formFields`, `$submissionCount` |
| Constant | UPPER_SNAKE | `STATUS_PUBLISHED` |
| Config key | snake_case | `form_uploads` |

### 34.3 Frontend Naming

| Element | Convention | Contoh |
|---------|-----------|--------|
| Blade file | kebab-case | `form-builder.blade.php` |
| Blade partial | `_` prefix | `_form-styles.blade.php` |
| CSS class | BEM-like (prefix `df-`) | `df-field`, `df-field__label`, `df-field--required` |
| JavaScript function | camelCase | `initFormBuilder()`, `handleSubmit()` |
| JavaScript constant | UPPER_SNAKE | `MAX_FILE_SIZE` |
| Route name | dot notation | `admin.dynamic-form.index` |
| URL path | kebab-case | `/admin/dynamic-form` |

### 34.4 CSS Class Prefix Convention

```css
/* Dynamic Form prefix: df- */
.df-form { }           /* Form container */
.df-field { }          /* Field wrapper */
.df-field__label { }   /* Field label */
.df-field__input { }   /* Field input */
.df-field__help { }    /* Field help text */
.df-field__error { }   /* Field error message */
.df-field--required { } /* Required modifier */
.df-field--disabled { } /* Disabled modifier */

/* Form Builder prefix: dfb- */
.dfb-canvas { }        /* Builder canvas */
.dfb-sidebar { }       /* Builder sidebar */
.dfb-property { }      /* Property panel */
.dfb-field-item { }    /* Draggable field item */

/* Spreadsheet prefix: dfs- */
.dfs-table { }         /* Spreadsheet table */
.dfs-header { }        /* Table header */
.dfs-cell { }          /* Table cell */
.dfs-toolbar { }       /* Toolbar */
```

---

## 35. Coding Standard Recommendation

### 35.1 PHP Standards

```php
// 1. Model structure (sesuai existing pattern)
class MsForm extends Model
{
    // A. Constants
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    // B. Table configuration
    protected $table = 'ms_form';
    protected $primaryKey = 'formID';
    public $timestamps = false;

    // C. Mass assignment
    protected $fillable = [...];

    // D. Casts
    protected $casts = [...];

    // E. Static configuration methods
    public static function getTableName(): string { }
    public static function attributeLabels(): array { }
    public static function getTableConfig(): array { }

    // F. Validation methods
    public static function validateRequest(Request $request, $ignoreId = null): array { }

    // G. CRUD methods
    public static function saveModel(Request $request): self { }
    public function updateModel(Request $request): void { }
    public function deleteModel(): void { }
    public static function bulkDeleteModel(array $ids): void { }

    // H. Search/query methods
    public static function searchAdminForms(Request $request) { }
    public static function searchPublicForms(Request $request) { }

    // I. Business logic methods
    public function publish(): void { }
    public function close(): void { }
    public function isAcceptingSubmissions(): bool { }

    // J. Relationships
    public function fields() { }
    public function submissions() { }
    public function sections() { }

    // K. Boot method
    protected static function booted(): void { }
}
```

### 35.2 Controller Standards

```php
// Controller harus tetap thin - delegate ke Model/Service
class DynamicFormController extends Controller
{
    // Maximum 10-15 lines per method
    // Business logic di Model atau Service
    // Validation di FormRequest atau Model::validateRequest

    public function store(Request $request)
    {
        MsForm::validateRequest($request);

        try {
            $form = MsForm::saveModel($request);
            return redirect()
                ->route('admin.dynamic-form.edit', $form->formID)
                ->with('success', 'Form berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
```

### 35.3 Service Layer Standards

```php
// Service untuk complex business logic yang melibatkan multiple models
class FormSubmissionService
{
    // Single responsibility: handle form submission flow

    public function processSubmission(MsForm $form, Request $request): TrFormSubmission
    {
        // 1. Validate
        // 2. Save
        // 3. Process files
        // 4. Dispatch jobs
        // Return result
    }
}

// Gunakan service jika:
// - Logic melibatkan 2+ models
// - Logic terlalu complex untuk 1 model method
// - Logic perlu reusable di multiple controllers
// - Logic involve external services (GDrive, Fonnte)
```

### 35.4 Error Handling Standards

```php
// Custom exceptions untuk domain-specific errors
class FormNotPublishedException extends \Exception { }
class FormExpiredException extends \Exception { }
class FormSubmissionLimitException extends \Exception { }
class FormFieldValidationException extends \Exception { }

// Controller error handling
public function submit(Request $request, $slug)
{
    try {
        $result = $this->submissionService->processSubmission($form, $request);
        return view('landing-page.form.thankyou', compact('form'));
    } catch (FormNotPublishedException $e) {
        return view('landing-page.form.closed', ['reason' => 'not_published']);
    } catch (FormExpiredException $e) {
        return view('landing-page.form.closed', ['reason' => 'expired']);
    } catch (FormSubmissionLimitException $e) {
        return view('landing-page.form.closed', ['reason' => 'full']);
    } catch (\Exception $e) {
        Log::error('Form submission error', ['slug' => $slug, 'error' => $e->getMessage()]);
        return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
    }
}
```

---

## 36. Migration Strategy

### 36.1 Migration Order

```
Urutan migrasi penting karena foreign key dependencies:

1. ms_form             (no dependencies)
2. ms_form_section     (depends on: ms_form)
3. ms_form_field       (depends on: ms_form, ms_form_section)
4. ms_form_setting     (depends on: ms_form)
5. tr_form_submission  (depends on: ms_form)
6. tr_form_answer      (depends on: tr_form_submission, ms_form_field)
7. tr_form_file        (depends on: tr_form_submission, ms_form_field)
8. tr_form_audit_log   (depends on: ms_form)
9. map_form_collaborator (depends on: ms_form, users)
```

### 36.2 Example Migration

```php
// database/migrations/2026_05_20_000001_create_ms_form_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\MsForm;

class CreateMsFormTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(MsForm::getTableName())) {
            Schema::create(MsForm::getTableName(), function (Blueprint $table) {
                $table->bigIncrements('formID');
                $table->string('title', 255);
                $table->string('slug', 255)->unique();
                $table->text('description')->nullable();
                $table->enum('status', ['draft', 'published', 'closed', 'archived'])->default('draft');
                $table->unsignedInteger('version')->default(1);
                $table->json('themeConfig')->nullable();
                $table->string('headerImage', 500)->nullable();
                $table->string('headerImageGdriveID', 255)->nullable();
                $table->unsignedInteger('maxSubmission')->nullable();
                $table->tinyInteger('isMultipleSubmit')->default(0);
                $table->tinyInteger('requireLogin')->default(0);
                $table->dateTime('startDate')->nullable();
                $table->dateTime('endDate')->nullable();
                $table->text('confirmationMessage')->nullable();
                $table->string('redirectUrl', 500)->nullable();
                $table->json('notifyEmails')->nullable();
                $table->unsignedInteger('totalSubmission')->default(0);
                $table->tinyInteger('flagActive')->default(1);
                $table->string('createdBy', 100);
                $table->dateTime('createdDate')->useCurrent();
                $table->string('editedBy', 100)->nullable();
                $table->dateTime('editedDate')->nullable();

                // Indexes
                $table->index(['status', 'flagActive'], 'idx_form_status');
                $table->index(['startDate', 'endDate'], 'idx_form_dates');
                $table->index('createdDate', 'idx_form_created');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable(MsForm::getTableName())) {
            Schema::dropIfExists(MsForm::getTableName());
        }
    }
}
```

### 36.3 Rollback Strategy

```
Rollback dilakukan dalam urutan TERBALIK:
9 → 8 → 7 → 6 → 5 → 4 → 3 → 2 → 1

Sebelum deploy ke production:
1. Test migration di staging environment
2. Backup database
3. Run migration
4. Verify semua table terbuat dengan benar
5. Run seeder untuk test data
6. Jika gagal → rollback → fix → retry
```

---

## 37. Example Dummy Data

### 37.1 Form Master Data

```json
{
  "formID": 1,
  "title": "Pendaftaran Anggota Baru LDK Syahid 2026",
  "slug": "pendaftaran-anggota-baru-ldk-syahid-2026",
  "description": "Formulir pendaftaran calon anggota baru LDK Syahid UIN Jakarta periode 2026/2027",
  "status": "published",
  "version": 1,
  "themeConfig": {
    "primaryColor": "#0d9488",
    "backgroundColor": "#f0fdfa",
    "cardBackground": "#ffffff",
    "borderRadius": "12px"
  },
  "maxSubmission": 200,
  "isMultipleSubmit": 0,
  "requireLogin": 0,
  "startDate": "2026-05-20 00:00:00",
  "endDate": "2026-06-30 23:59:59",
  "confirmationMessage": "Terima kasih telah mendaftar! Tim kami akan menghubungi Anda dalam 3 hari kerja.",
  "notifyEmails": ["admin@ldksyahid.or.id", "rekrutmen@ldksyahid.or.id"],
  "totalSubmission": 47,
  "flagActive": 1,
  "createdBy": "Ahmad Admin",
  "createdDate": "2026-05-18 10:00:00"
}
```

### 37.2 Form Fields Data

```json
[
  {
    "formFieldID": 1,
    "formID": 1,
    "formSectionID": 1,
    "fieldType": "short_text",
    "label": "Nama Lengkap",
    "placeholder": "Masukkan nama lengkap sesuai KTP",
    "helpText": null,
    "isRequired": 1,
    "sortOrder": 1,
    "options": null,
    "validation": {"maxLength": 100},
    "defaultValue": null
  },
  {
    "formFieldID": 2,
    "formID": 1,
    "formSectionID": 1,
    "fieldType": "email",
    "label": "Email Aktif",
    "placeholder": "contoh@email.com",
    "helpText": "Gunakan email yang aktif untuk komunikasi selanjutnya",
    "isRequired": 1,
    "sortOrder": 2,
    "options": null,
    "validation": null,
    "defaultValue": null
  },
  {
    "formFieldID": 3,
    "formID": 1,
    "formSectionID": 1,
    "fieldType": "phone",
    "label": "Nomor WhatsApp",
    "placeholder": "08xxxxxxxxxx",
    "helpText": "Nomor yang terhubung WhatsApp",
    "isRequired": 1,
    "sortOrder": 3,
    "options": null,
    "validation": {"min": 10, "max": 15},
    "defaultValue": null
  },
  {
    "formFieldID": 4,
    "formID": 1,
    "formSectionID": 2,
    "fieldType": "dropdown",
    "label": "Fakultas",
    "placeholder": "Pilih fakultas",
    "helpText": null,
    "isRequired": 1,
    "sortOrder": 4,
    "options": [
      {"value": "fti", "label": "Fakultas Teknologi Informasi"},
      {"value": "feb", "label": "Fakultas Ekonomi & Bisnis"},
      {"value": "fkik", "label": "Fakultas Kedokteran & Ilmu Kesehatan"},
      {"value": "fsh", "label": "Fakultas Syariah & Hukum"},
      {"value": "fit", "label": "Fakultas Ilmu Tarbiyah & Keguruan"},
      {"value": "fdk", "label": "Fakultas Dakwah & Komunikasi"},
      {"value": "fuf", "label": "Fakultas Ushuluddin & Filsafat"},
      {"value": "fad", "label": "Fakultas Adab & Humaniora"},
      {"value": "fpsi", "label": "Fakultas Psikologi"},
      {"value": "fsaintek", "label": "Fakultas Sains & Teknologi"},
      {"value": "fdi", "label": "Fakultas Dirasat Islamiyah"},
      {"value": "fisip", "label": "Fakultas Ilmu Sosial & Ilmu Politik"}
    ],
    "validation": null,
    "defaultValue": null
  },
  {
    "formFieldID": 5,
    "formID": 1,
    "formSectionID": 2,
    "fieldType": "short_text",
    "label": "Program Studi",
    "placeholder": "Masukkan program studi Anda",
    "helpText": null,
    "isRequired": 1,
    "sortOrder": 5,
    "options": null,
    "validation": {"maxLength": 100},
    "defaultValue": null
  },
  {
    "formFieldID": 6,
    "formID": 1,
    "formSectionID": 2,
    "fieldType": "number",
    "label": "Semester",
    "placeholder": "1-14",
    "helpText": "Semester saat ini",
    "isRequired": 1,
    "sortOrder": 6,
    "options": null,
    "validation": {"min": 1, "max": 14},
    "defaultValue": null
  },
  {
    "formFieldID": 7,
    "formID": 1,
    "formSectionID": 3,
    "fieldType": "long_text",
    "label": "Motivasi Bergabung",
    "placeholder": "Ceritakan motivasi Anda bergabung dengan LDK Syahid",
    "helpText": "Minimal 50 kata",
    "isRequired": 1,
    "sortOrder": 7,
    "options": null,
    "validation": {"minLength": 50, "maxLength": 1000},
    "defaultValue": null
  },
  {
    "formFieldID": 8,
    "formID": 1,
    "formSectionID": 3,
    "fieldType": "checkbox",
    "label": "Bidang yang Diminati",
    "placeholder": null,
    "helpText": "Boleh pilih lebih dari satu",
    "isRequired": 1,
    "sortOrder": 8,
    "options": [
      {"value": "dakwah", "label": "Dakwah & Syiar"},
      {"value": "media", "label": "Media & Komunikasi"},
      {"value": "sosial", "label": "Sosial & Kemasyarakatan"},
      {"value": "keilmuan", "label": "Keilmuan & Kajian"},
      {"value": "olahraga", "label": "Olahraga & Kesehatan"},
      {"value": "seni", "label": "Seni & Kreativitas"}
    ],
    "validation": {"min": 1, "max": 3},
    "defaultValue": null
  },
  {
    "formFieldID": 9,
    "formID": 1,
    "formSectionID": 3,
    "fieldType": "image_upload",
    "label": "Pas Foto",
    "placeholder": null,
    "helpText": "Upload pas foto 3x4 dengan background biru. Format: JPG/PNG, Max: 2MB",
    "isRequired": 1,
    "sortOrder": 9,
    "options": null,
    "validation": {"maxSize": 2048, "allowedTypes": ["image/jpeg", "image/png"]},
    "defaultValue": null
  },
  {
    "formFieldID": 10,
    "formID": 1,
    "formSectionID": 3,
    "fieldType": "yes_no",
    "label": "Bersedia mengikuti masa orientasi?",
    "placeholder": null,
    "helpText": "Masa orientasi akan dilaksanakan selama 2 minggu",
    "isRequired": 1,
    "sortOrder": 10,
    "options": {"style": "radio"},
    "validation": null,
    "defaultValue": null
  }
]
```

### 37.3 Submission Data

```json
{
  "formSubmissionID": 47,
  "formID": 1,
  "formVersion": 1,
  "respondentName": "Fatimah Azzahra",
  "respondentEmail": "fatimah.azzahra@student.uinjkt.ac.id",
  "respondentPhone": "081234567890",
  "answersJson": {
    "field_1": "Fatimah Azzahra",
    "field_2": "fatimah.azzahra@student.uinjkt.ac.id",
    "field_3": "081234567890",
    "field_4": "fti",
    "field_5": "Teknik Informatika",
    "field_6": 3,
    "field_7": "Saya ingin bergabung dengan LDK Syahid karena ingin memperdalam ilmu agama sekaligus berkontribusi dalam dakwah kampus. Saya percaya bahwa organisasi ini dapat membantu saya berkembang secara spiritual dan sosial.",
    "field_8": ["dakwah", "media", "keilmuan"],
    "field_9": {
      "fileId": "temp_abc123",
      "fileName": "pasfoto_fatimah.jpg",
      "fileSize": 456789,
      "mimeType": "image/jpeg"
    },
    "field_10": true
  },
  "ipAddress": "103.28.12.45",
  "userAgent": "Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X)",
  "deviceType": "mobile",
  "submittedAt": "2026-05-25 14:32:15",
  "duration": 342,
  "flagValid": 1,
  "flagRead": 0
}
```

---

## 38. Example API Payload

### 38.1 Create Form (Admin)

**Request:**
```http
POST /admin/dynamic-form/store
Content-Type: application/json
X-CSRF-TOKEN: {token}

{
  "title": "Pendaftaran Anggota Baru LDK Syahid 2026",
  "description": "Formulir pendaftaran calon anggota baru",
  "themeConfig": {
    "primaryColor": "#0d9488",
    "backgroundColor": "#f0fdfa"
  },
  "settings": {
    "maxSubmission": 200,
    "isMultipleSubmit": false,
    "requireLogin": false,
    "startDate": "2026-05-20T00:00:00+07:00",
    "endDate": "2026-06-30T23:59:59+07:00",
    "confirmationMessage": "Terima kasih telah mendaftar!"
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Form berhasil dibuat",
  "data": {
    "formID": 1,
    "slug": "pendaftaran-anggota-baru-ldk-syahid-2026",
    "status": "draft",
    "editUrl": "/admin/dynamic-form/1/edit"
  }
}
```

### 38.2 Add Field (Admin AJAX)

**Request:**
```http
POST /admin/dynamic-form/1/fields
Content-Type: application/json
X-CSRF-TOKEN: {token}

{
  "fieldType": "dropdown",
  "label": "Fakultas",
  "placeholder": "Pilih fakultas",
  "isRequired": true,
  "sortOrder": 4,
  "formSectionID": 2,
  "options": [
    {"value": "fti", "label": "Fakultas Teknologi Informasi"},
    {"value": "feb", "label": "Fakultas Ekonomi & Bisnis"}
  ],
  "validation": null
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "formFieldID": 4,
    "fieldType": "dropdown",
    "label": "Fakultas",
    "sortOrder": 4
  }
}
```

### 38.3 Submit Form (Public)

**Request:**
```http
POST /form/pendaftaran-anggota-baru-ldk-syahid-2026/submit
Content-Type: multipart/form-data
X-CSRF-TOKEN: {token}

{
  "_form_started": "{encrypted_timestamp}",
  "_form_token": "{js_generated_token}",
  "website_url": "",
  "answers": {
    "field_1": "Fatimah Azzahra",
    "field_2": "fatimah@student.uinjkt.ac.id",
    "field_3": "081234567890",
    "field_4": "fti",
    "field_5": "Teknik Informatika",
    "field_6": 3,
    "field_7": "Saya ingin bergabung...",
    "field_8": ["dakwah", "media"],
    "field_9": "{previously_uploaded_temp_file_id}",
    "field_10": true
  }
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Terima kasih telah mendaftar!",
  "redirect": "/form/pendaftaran-anggota-baru-ldk-syahid-2026/thankyou"
}
```

**Response (Validation Error):**
```json
{
  "success": false,
  "errors": {
    "answers.field_1": ["Nama Lengkap wajib diisi"],
    "answers.field_7": ["Motivasi minimal 50 kata"]
  }
}
```

### 38.4 Get Spreadsheet Data (Admin AJAX)

**Request:**
```http
GET /admin/dynamic-form/1/responses?page=1&perPage=25&sort_field=submittedAt&sort_dir=desc&search=fatimah
```

**Response:**
```json
{
  "tableBody": "<tr>...</tr><tr>...</tr>",
  "pagination": "<nav>...</nav>",
  "total": 47,
  "from": 1,
  "to": 25
}
```

---

## 39. Example JSON Structure

### 39.1 Field Options JSON

```json
// Dropdown/Multiple Choice/Checkbox options
{
  "options": [
    {"value": "option_1", "label": "Pilihan Pertama"},
    {"value": "option_2", "label": "Pilihan Kedua"},
    {"value": "option_3", "label": "Pilihan Ketiga", "isDefault": true}
  ]
}

// Rating options
{
  "options": {
    "maxStars": 5,
    "icon": "star",
    "labels": {
      "1": "Sangat Buruk",
      "2": "Buruk",
      "3": "Cukup",
      "4": "Baik",
      "5": "Sangat Baik"
    }
  }
}

// Linear Scale options
{
  "options": {
    "minValue": 1,
    "maxValue": 10,
    "minLabel": "Tidak Setuju",
    "maxLabel": "Sangat Setuju",
    "step": 1
  }
}

// File Upload options (stored in validation)
{
  "validation": {
    "maxSize": 5120,
    "allowedTypes": ["image/jpeg", "image/png", "application/pdf"],
    "maxFiles": 3
  }
}
```

### 39.2 Validation JSON

```json
// Short text validation
{
  "validation": {
    "minLength": 3,
    "maxLength": 100,
    "pattern": "^[a-zA-Z\\s]+$",
    "patternMessage": "Hanya boleh huruf dan spasi"
  }
}

// Number validation
{
  "validation": {
    "min": 1,
    "max": 14,
    "step": 1,
    "integer": true
  }
}

// Date validation
{
  "validation": {
    "minDate": "2026-01-01",
    "maxDate": "2026-12-31",
    "excludeWeekends": false
  }
}

// Phone validation
{
  "validation": {
    "format": "indonesia",
    "minDigits": 10,
    "maxDigits": 13
  }
}
```

### 39.3 Conditional Logic JSON (Future)

```json
{
  "conditionalLogic": {
    "action": "show",
    "logic": "all",
    "conditions": [
      {
        "fieldID": 4,
        "operator": "equals",
        "value": "fti"
      },
      {
        "fieldID": 6,
        "operator": "greater_than",
        "value": 2
      }
    ]
  }
}
```

### 39.4 Theme Config JSON

```json
{
  "themeConfig": {
    "colors": {
      "primary": "#0d9488",
      "secondary": "#6366f1",
      "background": "#f0fdfa",
      "card": "#ffffff",
      "text": "#1e293b",
      "textMuted": "#64748b",
      "border": "#e2e8f0",
      "error": "#ef4444",
      "success": "#22c55e"
    },
    "typography": {
      "fontFamily": "Inter, sans-serif",
      "titleSize": "1.75rem",
      "labelSize": "0.875rem",
      "inputSize": "1rem"
    },
    "layout": {
      "borderRadius": "12px",
      "cardShadow": "0 4px 6px -1px rgba(0,0,0,0.1)",
      "maxWidth": "720px",
      "padding": "2rem"
    },
    "branding": {
      "showLogo": true,
      "logoPosition": "center",
      "showPoweredBy": true,
      "customCSS": ""
    }
  }
}
```

### 39.5 Audit Log Payload JSON

```json
{
  "payload": {
    "action": "field_updated",
    "before": {
      "label": "Nama",
      "isRequired": false,
      "validation": null
    },
    "after": {
      "label": "Nama Lengkap",
      "isRequired": true,
      "validation": {"maxLength": 100}
    },
    "changedFields": ["label", "isRequired", "validation"]
  }
}
```

---

## 40. Edge Cases

### 40.1 Edge Cases yang Harus Diantisipasi

| No | Edge Case | Solusi |
|----|-----------|--------|
| 1 | User submit form tepat saat form expired | Check `isAcceptingSubmissions()` di awal proses submit, bukan hanya saat load page |
| 2 | Admin menghapus field yang sudah ada data | Soft delete field, data submission tetap utuh di JSON |
| 3 | Concurrent submission mencapai maxSubmission | Gunakan database lock / atomic increment check |
| 4 | File upload gagal di tengah submission | Temp file cleanup, user bisa re-upload tanpa kehilangan data lain |
| 5 | User submit dengan browser tab lama (CSRF expired) | Graceful error message, offer to re-submit |
| 6 | Very long text di text area (> 64KB) | Set TEXT column, frontend max character limiter |
| 7 | Duplicate submission (double click) | Debounce button + server-side duplicate check (same IP + same answers within 10s) |
| 8 | Form slug conflict | Auto-append number suffix: `form-name-2` |
| 9 | Admin membuat form tanpa field lalu publish | Block publish jika 0 input fields |
| 10 | Export dengan 100,000+ rows | Chunked processing, background job, streaming download |
| 11 | File upload with malicious content | Magic bytes check, upload to isolated storage, no direct execution |
| 12 | XSS via form field answers | Always escape output, store raw, render escaped |
| 13 | JSON answers melebihi MySQL max packet size | Limit total JSON size (check before insert, max 16MB) |
| 14 | Network timeout saat file upload | Chunked upload, resume capability |
| 15 | Mobile user with slow connection | Progressive loading, optimistic UI |
| 16 | Form version mismatch (user loads v1, admin updates to v2, user submits v1) | Save `formVersion` di submission, accept both versions |
| 17 | Admin deletes form yang masih ada submission aktif | RESTRICT delete jika ada submissions, force archive instead |
| 18 | Rate limit false positive (shared IP/NAT) | Per-session rate limit fallback, CAPTCHA as last resort |
| 19 | Emoji/Unicode dalam text answers | UTF8MB4 charset, proper JSON encoding |
| 20 | Browser back button after submission | Clear form state, show "already submitted" if applicable |

### 40.2 Concurrent Access Handling

```php
// Atomic check untuk max submission
public function submit(Request $request, $slug)
{
    $form = MsForm::where('slug', $slug)->lockForUpdate()->first();

    if ($form->maxSubmission && $form->totalSubmission >= $form->maxSubmission) {
        return response()->json([
            'success' => false,
            'message' => 'Maaf, kuota pendaftaran sudah penuh.'
        ], 422);
    }

    // Process submission...
    $form->increment('totalSubmission');
}
```

---

## 41. Risks & Mitigation

### 41.1 Technical Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|-----------|
| JSON query performance degrades at scale | Medium | High | EAV index table, caching, pagination |
| File storage quota exceeded (Google Drive) | Low | High | Monitor usage, implement cleanup, alerting |
| Database deadlock on concurrent submissions | Low | Medium | Optimize transactions, retry mechanism |
| XSS vulnerability via stored answers | Medium | High | Always escape output, CSP headers |
| Data loss during export process | Low | High | Transaction-based export, temp file verification |
| Memory overflow during large export | Medium | Medium | Chunked processing, stream writing |
| Form builder UI complexity overwhelms users | Medium | Medium | Progressive disclosure, tooltips, tutorials |
| Migration fails on production | Low | Critical | Test on staging, backup before deploy |

### 41.2 Business Risks

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|-----------|
| Spam submissions flood system | High | Medium | Multi-layer anti-spam, monitoring |
| Users submit sensitive data (PII) | High | High | Data retention policy, access control, encryption at rest |
| Form link shared publicly causes unexpected load | Medium | Medium | Rate limiting, auto-close at limit |
| Admin accidentally deletes form with data | Medium | High | Soft delete, confirmation dialog, 30-day recovery |
| GDPR/data privacy compliance | Medium | High | Data export capability, deletion mechanism |

### 41.3 Mitigation Action Plan

```
Priority 1 (Before Launch):
├── Implement rate limiting on all endpoints
├── XSS prevention audit
├── CSRF protection verification
├── File upload security testing
├── Database backup automation
└── Soft delete implementation

Priority 2 (Within 2 Weeks):
├── Anti-spam measures
├── Monitoring & alerting setup
├── Export performance optimization
├── Error handling & logging
└── User documentation

Priority 3 (Ongoing):
├── Performance monitoring
├── Security patches
├── Database maintenance (archive old data)
├── User feedback integration
└── Feature improvement iteration
```

---

## 42. Development Phase Recommendation

### 42.1 Phase Breakdown

```
┌─────────────────────────────────────────────────────────────────┐
│ PHASE 1: Foundation (MVP)                                       │
├─────────────────────────────────────────────────────────────────┤
│ - Database migration (all tables)                               │
│ - Models with basic CRUD                                        │
│ - Admin: Form list page                                         │
│ - Admin: Simple form builder (no drag-drop)                     │
│ - Admin: Basic field types (text, email, dropdown, checkbox)    │
│ - Public: Form render & submit                                  │
│ - Public: Basic validation                                      │
│ - Admin: Spreadsheet view (basic table)                         │
│ - Thank you page                                                │
│ - Security: CSRF, rate limiting, honeypot                       │
└─────────────────────────────────────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│ PHASE 2: Enhancement                                            │
├─────────────────────────────────────────────────────────────────┤
│ - Drag & drop form builder                                      │
│ - All field types implemented                                   │
│ - File upload integration (Google Drive)                        │
│ - Export Excel/CSV                                              │
│ - Spreadsheet filter & search                                   │
│ - Form theming & customization                                  │
│ - Email notifications                                           │
│ - Draft/Publish mechanism                                       │
│ - Form expiration                                               │
│ - Versioning                                                    │
└─────────────────────────────────────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│ PHASE 3: Polish & Scale                                         │
├─────────────────────────────────────────────────────────────────┤
│ - WhatsApp notifications (Fonnte)                               │
│ - Collaborator management                                       │
│ - Audit logging                                                 │
│ - Form duplication                                              │
│ - Advanced anti-spam                                            │
│ - Performance optimization                                      │
│ - Form analytics                                                │
│ - Bulk operations                                               │
│ - Admin UI polish                                               │
│ - Mobile responsive optimization                                │
└─────────────────────────────────────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│ PHASE 4: Advanced (Future)                                      │
├─────────────────────────────────────────────────────────────────┤
│ - Conditional logic                                             │
│ - Multi-page forms                                              │
│ - Form templates                                                │
│ - Webhooks                                                      │
│ - Public API                                                    │
│ - Payment integration                                           │
│ - QR code generation                                            │
└─────────────────────────────────────────────────────────────────┘
```

### 42.2 Phase 1 Deliverables (Detail)

| No | Task | Priority | Dependencies |
|----|------|----------|-------------|
| 1 | Create database migrations | Critical | None |
| 2 | Create Eloquent models | Critical | Migration |
| 3 | Create FormBuilderService | Critical | Models |
| 4 | Create DynamicFormController | Critical | Service |
| 5 | Admin: Form list view | Critical | Controller |
| 6 | Admin: Form create/edit view | Critical | Controller |
| 7 | Admin: Field management (AJAX) | Critical | Controller |
| 8 | Create PublicFormController | Critical | Service |
| 9 | Public: Form display view | Critical | Controller |
| 10 | Public: Submission handling | Critical | Controller |
| 11 | Admin: Spreadsheet response view | High | Submission |
| 12 | Rate limiting & CSRF | High | Routes |
| 13 | Honeypot anti-spam | Medium | Form view |
| 14 | Thank you page | Medium | Submission |
| 15 | Form validation builder | High | Fields |

---

## 43. Testing Strategy

### 43.1 Test Types

| Test Type | Coverage Target | Tools |
|-----------|----------------|-------|
| Unit Test | Models, Services, Helpers | PHPUnit |
| Feature Test | Controllers, Routes, Middleware | PHPUnit + Laravel TestCase |
| Integration Test | Database queries, File operations | PHPUnit + TestCase |
| Browser Test | Form builder UI, Public form | Laravel Dusk (optional) |
| Manual Test | UX flow, Visual check | QA Checklist |

### 43.2 Key Test Cases

```php
// tests/Feature/DynamicForm/FormCreationTest.php
class FormCreationTest extends TestCase
{
    /** @test */
    public function admin_can_create_form()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Superadmin');

        $response = $this->actingAs($admin)->post(route('admin.dynamic-form.store'), [
            'title' => 'Test Form',
            'description' => 'A test form',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ms_form', ['title' => 'Test Form', 'status' => 'draft']);
    }

    /** @test */
    public function user_role_cannot_access_form_admin()
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $response = $this->actingAs($user)->get(route('admin.dynamic-form.index'));
        $response->assertForbidden();
    }

    /** @test */
    public function form_slug_is_auto_generated_and_unique()
    {
        // Create first form
        $form1 = MsForm::saveModel(new Request(['title' => 'My Form']));
        $this->assertEquals('my-form', $form1->slug);

        // Create second form with same title
        $form2 = MsForm::saveModel(new Request(['title' => 'My Form']));
        $this->assertEquals('my-form-2', $form2->slug);
    }
}

// tests/Feature/DynamicForm/FormSubmissionTest.php
class FormSubmissionTest extends TestCase
{
    /** @test */
    public function user_can_submit_published_form()
    {
        $form = MsForm::factory()->published()->create();
        MsFormField::factory()->count(3)->create(['formID' => $form->formID]);

        $response = $this->post(route('form.submit', $form->slug), [
            '_form_started' => encrypt(time() - 60),
            '_form_token' => base64_encode(time() . ':abc:5'),
            'answers' => [
                'field_1' => 'John Doe',
                'field_2' => 'john@email.com',
                'field_3' => 'Hello World',
            ],
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('tr_form_submission', ['formID' => $form->formID]);
    }

    /** @test */
    public function cannot_submit_expired_form()
    {
        $form = MsForm::factory()->create([
            'status' => 'published',
            'endDate' => now()->subDay(),
        ]);

        $response = $this->post(route('form.submit', $form->slug), ['answers' => []]);
        $response->assertStatus(422);
    }

    /** @test */
    public function submission_respects_max_limit()
    {
        $form = MsForm::factory()->create([
            'status' => 'published',
            'maxSubmission' => 1,
            'totalSubmission' => 1,
        ]);

        $response = $this->post(route('form.submit', $form->slug), ['answers' => []]);
        $response->assertStatus(422);
    }

    /** @test */
    public function honeypot_rejects_bot_submissions()
    {
        $form = MsForm::factory()->published()->create();

        $response = $this->post(route('form.submit', $form->slug), [
            'website_url' => 'http://spam.com', // Honeypot filled = bot
            'answers' => ['field_1' => 'Bot Data'],
        ]);

        // Should return fake success but not save
        $this->assertDatabaseMissing('tr_form_submission', ['formID' => $form->formID]);
    }

    /** @test */
    public function timing_check_flags_fast_submissions()
    {
        $form = MsForm::factory()->published()->create();

        $response = $this->post(route('form.submit', $form->slug), [
            '_form_started' => encrypt(time()), // 0 seconds = too fast
            'answers' => ['field_1' => 'Fast Bot'],
        ]);

        // Should flag as spam
        $submission = TrFormSubmission::where('formID', $form->formID)->first();
        $this->assertFalse($submission->flagValid);
    }
}

// tests/Feature/DynamicForm/SpreadsheetTest.php
class SpreadsheetTest extends TestCase
{
    /** @test */
    public function admin_can_view_spreadsheet_with_correct_columns()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Superadmin');

        $form = MsForm::factory()->create();
        $fields = MsFormField::factory()->count(5)->create(['formID' => $form->formID]);

        $response = $this->actingAs($admin)
            ->get(route('admin.dynamic-form.responses.index', $form->formID));

        $response->assertOk();
        foreach ($fields as $field) {
            $response->assertSee($field->label);
        }
    }

    /** @test */
    public function spreadsheet_supports_search_across_json()
    {
        // Test JSON_EXTRACT search functionality
    }

    /** @test */
    public function export_generates_correct_excel_file()
    {
        // Test export functionality
    }
}
```

---

## 44. QA Checklist

### 44.1 Form Builder (Admin)

- [ ] Form bisa dibuat dengan judul dan deskripsi
- [ ] Slug auto-generated dari judul
- [ ] Slug conflict handled (auto-increment suffix)
- [ ] Semua 20 field types bisa ditambahkan
- [ ] Field bisa di-reorder (drag & drop)
- [ ] Field bisa diedit (label, placeholder, help text)
- [ ] Field bisa dihapus (soft delete)
- [ ] Section bisa ditambah/edit/hapus
- [ ] Required toggle berfungsi
- [ ] Validation rules bisa di-set per field
- [ ] Options bisa ditambah/edit/hapus (dropdown/radio/checkbox)
- [ ] Theme customization berfungsi (warna, font)
- [ ] Header image bisa diupload
- [ ] Preview mode menampilkan form dengan benar
- [ ] Auto-save draft berfungsi
- [ ] Publish validation (minimal 1 input field)
- [ ] Form settings tersimpan dengan benar
- [ ] Collaborator management berfungsi
- [ ] Audit log tercatat untuk setiap aksi
- [ ] Responsive layout di admin panel

### 44.2 Public Form

- [ ] Form accessible via slug URL
- [ ] Draft form tidak bisa diakses public
- [ ] Closed form menampilkan pesan yang sesuai
- [ ] Expired form menampilkan pesan yang sesuai
- [ ] Full form (max submission reached) menampilkan pesan
- [ ] Semua field types render dengan benar
- [ ] Required fields menampilkan indicator (*)
- [ ] Client-side validation berfungsi per field type
- [ ] Server-side validation berfungsi per field type
- [ ] Error messages tampil di bawah field yang error
- [ ] File upload berfungsi (temp upload → permanent)
- [ ] File type restriction berfungsi
- [ ] File size limit berfungsi
- [ ] CSRF protection aktif
- [ ] Honeypot rejection berfungsi
- [ ] Timing check berfungsi
- [ ] Rate limiting berfungsi
- [ ] Thank you page tampil setelah submit
- [ ] Redirect berfungsi (jika di-set)
- [ ] Email notification terkirim
- [ ] Form responsive di mobile/tablet
- [ ] Dark mode support (jika project mendukung)
- [ ] Multiple submission prevention (double-click)

### 44.3 Spreadsheet Response (Admin)

- [ ] Kolom sesuai dengan field form
- [ ] Data submission tampil dengan benar
- [ ] Pagination berfungsi
- [ ] Search berfungsi (across all fields)
- [ ] Sort per kolom berfungsi
- [ ] Filter per kolom berfungsi
- [ ] Column show/hide toggle berfungsi
- [ ] Detail view menampilkan semua jawaban
- [ ] File preview berfungsi di detail view
- [ ] Export Excel berfungsi
- [ ] Export CSV berfungsi
- [ ] Export dengan filter berfungsi
- [ ] Bulk delete berfungsi
- [ ] Single delete berfungsi
- [ ] Flag spam/valid berfungsi
- [ ] Submission counter akurat
- [ ] Historical columns (deleted fields) handled

### 44.4 Security Checklist

- [ ] XSS prevention: all output escaped
- [ ] SQL injection: parameterized queries only
- [ ] CSRF: token validated on all POST/PUT/DELETE
- [ ] File upload: magic bytes validated
- [ ] File upload: no executable content
- [ ] Rate limiting: enforced on all public endpoints
- [ ] Authentication: admin routes protected
- [ ] Authorization: role-based access enforced
- [ ] Authorization: ownership check on edit/delete
- [ ] Data sanitization: no raw user input in responses
- [ ] HTTPS: enforced on all pages
- [ ] Headers: security headers present (CSP, X-Frame-Options)

---

## 45. Deployment Checklist

### 45.1 Pre-Deployment

- [ ] All migrations tested on staging
- [ ] Database backup completed
- [ ] Environment variables configured
- [ ] Google Drive folder created for form uploads
- [ ] Queue worker configured and running
- [ ] Cron job configured (`forms:close-expired`)
- [ ] Rate limiter configuration verified
- [ ] File permissions correct (storage/)
- [ ] Dependencies installed (`composer install --no-dev`)
- [ ] Assets compiled (`npm run production`)
- [ ] Cache cleared (`php artisan cache:clear`)
- [ ] Config cached (`php artisan config:cache`)
- [ ] Routes cached (`php artisan route:cache`)
- [ ] Views cached (`php artisan view:cache`)

### 45.2 Deployment Steps

```
1. Maintenance mode ON
   php artisan down --message="Sedang dalam maintenance"

2. Pull latest code
   git pull origin main

3. Install dependencies
   composer install --no-dev --optimize-autoloader

4. Run migrations
   php artisan migrate --force

5. Clear and rebuild caches
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache

6. Restart queue workers
   php artisan queue:restart

7. Compile assets (if changed)
   npm run production

8. Verify application
   - Check homepage loads
   - Check admin panel accessible
   - Check form creation works
   - Check public form renders

9. Maintenance mode OFF
   php artisan up
```

### 45.3 Post-Deployment Verification

- [ ] Application accessible (no 500 error)
- [ ] Admin panel loads correctly
- [ ] Create test form → success
- [ ] Publish test form → success
- [ ] Access public form → renders correctly
- [ ] Submit test form → success
- [ ] View spreadsheet → data appears
- [ ] Export → file generated
- [ ] Delete test form → success
- [ ] Queue worker processing jobs
- [ ] Cron job registered
- [ ] No errors in log file (`storage/logs/laravel.log`)
- [ ] Performance acceptable (page load < 2s)

### 45.4 Rollback Plan

```
Jika deployment gagal:

1. php artisan down
2. php artisan migrate:rollback --step=9  (rollback form tables)
3. git checkout previous-commit
4. composer install --no-dev
5. php artisan config:cache
6. php artisan route:cache
7. php artisan up
8. Notify team, investigate issue
```

---

## Lampiran A: Technology Stack Summary

| Layer | Technology | Version |
|-------|-----------|---------|
| Language | PHP | 7.3+ / 8.0+ |
| Framework | Laravel | 8.75+ |
| Database | MySQL | 8.0+ |
| Cache | File | CACHE_DRIVER=file |
| Queue | Database (custom-database) | tr_job_queue table |
| Auth | Spatie Permission | v5.9 |
| API Auth | Laravel Sanctum | v2.11 |
| File Storage | Google Drive API | - |
| PDF | DomPDF | - |
| Excel | PhpSpreadsheet / Maatwebsite | - |
| WhatsApp | Fonnte API | - |
| Frontend | Blade + Alpine.js | - |
| CSS | Bootstrap 5 + Custom | - |
| Drag & Drop | SortableJS | - |
| Date Picker | Flatpickr | - |
| File Upload UI | FilePond | - |

---

## Lampiran B: Glossary

| Term | Definisi |
|------|---------|
| Form | Formulir dinamis yang dibuat admin |
| Field | Pertanyaan/input dalam form |
| Section | Grup/kelompok field dalam form |
| Submission | Data yang disubmit user |
| Answer | Jawaban per field dalam submission |
| Spreadsheet | Tampilan tabel dari semua submission |
| EAV | Entity-Attribute-Value pattern |
| Slug | URL-friendly identifier |
| Honeypot | Hidden field anti-spam technique |
| Soft Delete | Flag-based deletion (data tetap ada) |
| Version | Versi form setelah structural change |

---

## Lampiran C: Decision Log

| # | Decision | Alasan | Alternative Considered |
|---|----------|--------|----------------------|
| 1 | Hybrid JSON + EAV storage | Balance flexibility & query performance | Dynamic columns, Pure EAV, Pure JSON |
| 2 | Server-side table rendering | Consistent with project, no heavy JS framework needed | React DataTable, Vue component |
| 3 | Google Drive for file storage | Existing integration in project | Local storage, S3 |
| 4 | Alpine.js for admin interactivity | Lightweight, no build step | React, Vue, vanilla JS |
| 5 | Background jobs for export | Prevent timeout on large datasets | Streaming download, pagination |
| 6 | Soft delete for fields | Preserve historical submission integrity | Hard delete with backup |
| 7 | JSON theme config | Flexible, no migration needed for new theme options | Separate theme table |
| 8 | Per-form rate limiting | Different forms have different sensitivity | Global rate limit only |
| 9 | Snapshot versioning | Simple to implement, covers most cases | Full version history with diff |
| 10 | CSRF + Honeypot + Timing | Layered security without user friction | reCAPTCHA (adds UX friction) |

---

## 46. Google Drive Integration Workflow

> **Confirmed Architecture:** Semua file attachment dan jawaban form disimpan di Google Drive — bukan di local storage maupun database. Section ini mendeskripsikan workflow lengkap integrasi GDrive.

### 46.1 Root Folder Configuration

```
Root GDrive Folder: dynamic_form
Folder ID         : 1L-rydt4-GIgLo_jHw2BdJkFT4MZw7kvX
```

Folder ini harus sudah ada di GDrive dan Service Account harus memiliki akses **Editor** ke folder ini.

### 46.2 Workflow: Admin Create Form

```
Admin isi form title + fields + collaborator email
             │
             ▼
┌────────────────────────────────────────────────────────────────┐
│  GDrive Step 1: Buat Folder Form                               │
│                                                                │
│  POST ke Google Drive API:                                     │
│  - name: "{Form Title}"                                        │
│  - mimeType: "application/vnd.google-apps.folder"             │
│  - parents: ["1L-rydt4-GIgLo_jHw2BdJkFT4MZw7kvX"]            │
│                                                                │
│  Simpan hasilnya: gdriveFolderID → ms_form.gdriveFolderID     │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  GDrive Step 2: Buat Google Spreadsheet di dalam Folder Form   │
│                                                                │
│  POST ke Google Sheets API:                                    │
│  - title: "{Form Title} Responses"                             │
│  - parents: [gdriveFolderID dari Step 1]                       │
│                                                                │
│  Setup header row (kolom sesuai field form):                   │
│  [Timestamp, Nama, Email, {field_label_1}, {field_label_2}...] │
│                                                                │
│  Simpan: gdriveSpreadsheetID → ms_form.gdriveSpreadsheetID    │
│          gdriveSpreadsheetUrl → ms_form.gdriveSpreadsheetUrl  │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  GDrive Step 3: Buat Folder "attachments" di Folder Form       │
│                                                                │
│  POST ke Google Drive API:                                     │
│  - name: "attachments"                                         │
│  - mimeType: "application/vnd.google-apps.folder"             │
│  - parents: [gdriveFolderID dari Step 1]                       │
│                                                                │
│  Simpan: gdriveAttachmentsFolderID → ms_form.gdriveAttachments │
│          gdriveAttachmentsFolderUrl → ms_form.gdriveAttachments│
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  GDrive Step 4: Buat Subfolder per Field File/Image Upload     │
│                                                                │
│  Untuk setiap field yang bertipe file_upload / image_upload:   │
│  - Buat subfolder: name = field.label (sanitized)             │
│  - parents: [gdriveAttachmentsFolderID dari Step 3]           │
│  - Simpan folder ID ke ms_form_field.fieldConfig JSON:        │
│    {"gdriveFolderID": "xyz789"}                               │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  GDrive Step 5: Set Permission untuk Collaborator Email        │
│                                                                │
│  Jika collaboratorEmails diisi (tidak kosong):                 │
│  POST ke Google Drive Permissions API:                         │
│  - fileId: gdriveFolderID (folder form)                       │
│  - role: "writer" (Editor)                                    │
│  - type: "user"                                               │
│  - emailAddress: collaboratorEmail                            │
│                                                                │
│  Permission diberikan ke FOLDER FORM, bukan file individual.  │
│  Artinya collaborator bisa akses Spreadsheet + attachments.   │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  Database: Save ms_form record                                 │
│                                                                │
│  INSERT ms_form dengan semua GDrive IDs:                      │
│  - gdriveFolderID                                             │
│  - gdriveSpreadsheetID                                        │
│  - gdriveSpreadsheetUrl                                       │
│  - gdriveAttachmentsFolderID                                  │
│  - gdriveAttachmentsFolderUrl                                 │
│  - collaboratorEmails (JSON array)                            │
└────────────────────────────────────────────────────────────────┘
```

### 46.3 Workflow: User Submit Form

```
User isi form dan klik Submit
             │
             ▼
┌────────────────────────────────────────────────────────────────┐
│  Step A: Validasi & Anti-Spam                                  │
│  - Server-side validation semua field                          │
│  - Cek honeypot, timing, CSRF, rate limit                     │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  Step B: Upload File Attachment ke GDrive (jika ada)           │
│                                                                │
│  Untuk setiap file yang diupload user:                         │
│  1. Ambil gdriveFolderID dari fieldConfig (subfolder field)   │
│  2. Upload file ke GDrive folder tersebut via API             │
│  3. Nama file: "submission_{tempID}_{originalName}"           │
│  4. Dapatkan: gdriveFileID, gdriveFileUrl                     │
│  5. Simpan ID sementara, belum ke database                    │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  Step C: Append Row ke Google Sheets                           │
│                                                                │
│  1. Ambil gdriveSpreadsheetID dari ms_form                    │
│  2. Susun data row: [timestamp, answers..., links_file...]    │
│     - Field biasa: nilai jawaban langsung                     │
│     - Field file: link GDrive file (gdriveFileUrl)           │
│  3. POST ke Google Sheets API (spreadsheets.values.append)   │
│  4. Dapatkan nomor baris row yang baru dibuat (gsheetRowIndex)│
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  Step D: Simpan Metadata ke Database                           │
│                                                                │
│  INSERT tr_form_submission:                                    │
│  - formID, formVersion                                        │
│  - respondentName, respondentEmail (jika ada di form)        │
│  - gsheetRowIndex (dari Step C)                               │
│  - ipAddress, userAgent, deviceType                           │
│  - submittedAt, duration                                      │
│                                                                │
│  INSERT tr_form_file (per file yang diupload):                │
│  - formSubmissionID (dari INSERT di atas)                     │
│  - formFieldID, originalName, fileSize, mimeType             │
│  - gdriveFileID, gdriveFolderID, gdriveFileUrl               │
│                                                                │
│  UPDATE ms_form.totalSubmission + 1                           │
└──────────────────────────────┬─────────────────────────────────┘
                               │
                               ▼
┌────────────────────────────────────────────────────────────────┐
│  Step E: Post-Submission (Background Jobs)                     │
│  - Dispatch NotifySubmissionJob (email + WhatsApp ke admin)   │
│  - Log audit trail                                            │
│  - Response ke user: show confirmation / redirect             │
└────────────────────────────────────────────────────────────────┘
```

### 46.4 Yang Ditampilkan di Admin Page

Di halaman **detail form** pada admin panel, cukup tampilkan:

```
┌─────────────────────────────────────────────────────────────┐
│  Form: Pendaftaran Magang 2026                              │
│  Total Responses: 42                                        │
│                                                             │
│  📊 Lihat Responses  →  [Link Google Sheets]               │
│  📁 Lihat Attachment →  [Link Folder Attachments GDrive]   │
│                                                             │
│  [Tombol Edit Form]  [Tombol Close Form]  [Tombol Hapus]   │
└─────────────────────────────────────────────────────────────┘
```

Admin tidak perlu ada halaman "spreadsheet viewer" di dalam aplikasi — cukup buka langsung di Google Sheets.

### 46.5 Service Methods yang Perlu Dibuat

```php
// app/Services/DynamicFormGDriveService.php

class DynamicFormGDriveService
{
    // Dipanggil saat admin create form
    public function setupFormFolder(MsForm $form, array $fields): array
    {
        $formFolderID = $this->createFolder($form->title, config('services.gdrive.dynamic_form_root'));
        $spreadsheetID = $this->createSpreadsheet($form->title . ' Responses', $formFolderID, $fields);
        $attachmentsFolderID = $this->createFolder('attachments', $formFolderID);
        $fieldFolders = $this->createFieldFolders($fields, $attachmentsFolderID);
        $this->grantEditorAccess($formFolderID, $form->collaboratorEmails ?? []);

        return [
            'gdriveFolderID'             => $formFolderID,
            'gdriveSpreadsheetID'        => $spreadsheetID['spreadsheetId'],
            'gdriveSpreadsheetUrl'       => $spreadsheetID['url'],
            'gdriveAttachmentsFolderID'  => $attachmentsFolderID,
            'gdriveAttachmentsFolderUrl' => $this->getFolderUrl($attachmentsFolderID),
        ];
    }

    // Dipanggil saat user submit form
    public function appendSubmissionToSheet(string $spreadsheetID, array $rowData): int
    {
        // Returns row index (gsheetRowIndex)
    }

    // Dipanggil untuk upload file user
    public function uploadFileToFieldFolder(string $gdriveFolderID, UploadedFile $file, int $submissionID): array
    {
        // Returns ['gdriveFileID' => ..., 'gdriveFileUrl' => ...]
    }
}
```

### 46.6 Environment Variables yang Diperlukan

```env
# Google Drive - Dynamic Form Root Folder
GDRIVE_DYNAMIC_FORM_ROOT_FOLDER_ID=1L-rydt4-GIgLo_jHw2BdJkFT4MZw7kvX

# Google API Credentials (sudah ada di project, pastikan scope mencakup Sheets)
GOOGLE_APPLICATION_CREDENTIALS=/path/to/service-account.json
# atau jika menggunakan client secret:
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
GOOGLE_REFRESH_TOKEN=...
```

---

## 47. Setup Documentation

### 47.1 Daftar Komponen yang Perlu Di-setup

| Komponen | Status di Project | Perlu Setup Tambahan? |
|----------|-----------------|----------------------|
| Google Drive API | ✅ Sudah ada | ⚠️ Perlu tambah scope Google Sheets |
| Google Sheets API | ❌ Belum ada | ✅ Ya - enable API + tambah scope |
| Redis | ❌ Tidak digunakan | Tidak diperlukan — pakai file cache + custom-database queue |
| Laravel Queue Worker | ❓ Tergantung driver | ✅ Ya - perlu jalankan worker |
| Cron Job Laravel | ❓ Tergantung setup | ✅ Ya - untuk expired form checker |

---

### 47.2 Setup Google Sheets API

**Step 1: Enable Google Sheets API di Google Cloud Console**

```
1. Buka: https://console.cloud.google.com
2. Pilih project yang sama dengan Google Drive API yang sudah ada
3. Pergi ke: APIs & Services → Library
4. Cari "Google Sheets API" → klik → klik "Enable"
```

**Step 2: Pastikan Scope Google Sheets ada di Service Account / OAuth**

Jika menggunakan **Service Account** (direkomendasikan untuk server):
```
Scope yang dibutuhkan:
- https://www.googleapis.com/auth/spreadsheets
- https://www.googleapis.com/auth/drive

Cara cek: Buka file service-account.json → pastikan scope sudah benar
Jika menggunakan Spatie Google Drive package, tambahkan scope di config.
```

Jika menggunakan **OAuth 2.0**:
```
1. Buka: APIs & Services → Credentials → Edit OAuth Client
2. Tambahkan scope baru: .../auth/spreadsheets
3. Re-generate refresh token jika diperlukan
```

**Step 3: Verifikasi di config/google.php (atau config yang relevan)**

```php
// config/google.php atau tempat config GDrive yang sudah ada
'scopes' => [
    'https://www.googleapis.com/auth/drive',
    'https://www.googleapis.com/auth/spreadsheets', // ← tambahkan ini
],
```

**Step 4: Test koneksi Google Sheets**

```bash
php artisan tinker
# Jalankan:
# $client = app(\App\Services\GoogleDriveService::class);
# Coba buat spreadsheet test
```

---

### 47.3 Setup Laravel Queue Worker

Queue digunakan untuk background jobs seperti:
- Kirim notifikasi email/WhatsApp setelah submission
- Cleanup file temp yang tidak jadi disubmit

**Step 1: Jalankan Queue Worker**

```bash
# Untuk development (jalankan di terminal terpisah):
php artisan queue:work

# Untuk production (gunakan supervisor/pm2):
# Buat file konfigurasi supervisor:
```

```ini
; /etc/supervisor/conf.d/ldksyahid-worker.conf
[program:ldksyahid-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Aktifkan supervisor:
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start ldksyahid-worker:*
```

**Alternatif di Windows (Development):**

```bash
# Jalankan manual di terminal:
php artisan queue:work --verbose

# Untuk development (sync mode): tidak perlu worker, job langsung dieksekusi
```

---

### 47.5 Setup Cron Job (Laravel Scheduler)

Cron job diperlukan untuk: menjalankan `php artisan forms:close-expired` yang menutup form yang sudah melewati `endDate`.

**Untuk Linux/Mac (Production):**

```bash
# Edit crontab:
crontab -e

# Tambahkan baris ini:
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

**Untuk Windows (Development):**

```
1. Buka Task Scheduler (Penjadwal Tugas)
2. Klik "Create Basic Task"
3. Name: "Laravel Scheduler"
4. Trigger: Daily, repeat every 1 minute (set via Advanced settings)
5. Action: Start a program
   Program: php
   Arguments: C:\Apache24\htdocs\ldksyahid-app\artisan schedule:run
   Start in: C:\Apache24\htdocs\ldksyahid-app
6. Finish

# Atau gunakan cara sederhana di development: jalankan manual
php artisan schedule:run
```

---

### 47.6 Konfigurasi Environment Variables Lengkap

Tambahkan variabel berikut ke file `.env` project:

```env
# ===== Dynamic Form Builder Configuration =====

# Google Drive Root Folder untuk Dynamic Form
GDRIVE_DYNAMIC_FORM_ROOT_FOLDER_ID=1L-rydt4-GIgLo_jHw2BdJkFT4MZw7kvX

# ---- Queue (pilih salah satu sesuai environment) ----

# Development: sync = job langsung dieksekusi, tidak perlu queue worker
QUEUE_CONNECTION=sync

# Production (Domainesia): gunakan custom-database driver yang sudah ada
# QUEUE_CONNECTION=custom-database

# Rate Limiting (menggunakan Laravel built-in, tidak perlu config tambahan)
# Rate limit dikonfigurasi via RouteServiceProvider / AppServiceProvider
```

---

### 47.7 Checklist Setup Sebelum Mulai Development

```
# Google Drive & Sheets (WAJIB)
□ Google Drive API sudah aktif di Google Cloud Console
□ Google Sheets API sudah di-enable
□ Scope "https://www.googleapis.com/auth/spreadsheets" sudah ditambahkan ke credentials
□ Service Account / OAuth credentials sudah benar
□ Root folder GDrive "dynamic_form" sudah ada (ID: 1L-rydt4-GIgLo_jHw2BdJkFT4MZw7kvX)
□ Service Account sudah diberi akses Editor ke folder dynamic_form

# Environment (WAJIB)
□ .env sudah dikonfigurasi (GDRIVE_DYNAMIC_FORM_ROOT_FOLDER_ID)
□ Development: QUEUE_CONNECTION=sync di .env lokal
□ Production: QUEUE_CONNECTION=custom-database di .env production
□ php artisan config:clear dijalankan setelah update .env

# Database (WAJIB)
□ php artisan migrate dijalankan (membuat 8 tabel dynamic form)
□ Cek semua tabel terbuat: ms_form, ms_form_field, ms_form_section, ms_form_setting,
  tr_form_submission, tr_form_file, tr_form_audit_log, map_form_collaborator

# Testing (WAJIB sebelum production)
□ Coba create form baru → cek folder terbuat di GDrive
□ Coba submit form → cek row teradd di Google Sheets
□ Coba upload file → cek file masuk ke subfolder field di GDrive
□ Coba submit form → cek email konfirmasi terkirim ke respondent
□ Cek admin creator email punya akses Editor ke folder GDrive

# Tidak diperlukan
□ Redis: Tidak digunakan — cache pakai file driver, queue pakai custom-database
□ Supervisor: Tidak diperlukan — Domainesia shared hosting pakai cPanel cron
```

---

## 48. Confirmed Implementation Decisions (Pre-Development Review)

> **Status:** ✅ All decisions confirmed on 17 May 2026 before implementation begins.
> Bagian ini mencatat semua keputusan akhir yang dikonfirmasi sebelum coding dimulai.

---

### 48.1 Queue / Scheduler / Cron Job Strategy

| Environment | Queue Driver | Queue Worker | Scheduler |
|---|---|---|---|
| **Development (local)** | `sync` | Tidak diperlukan — job langsung dieksekusi | Tidak diperlukan |
| **Production (Domainesia)** | `custom-database` (existing `tr_job_queue`) | Via `schedule:run` cron (sudah ada) | Via cPanel cron: `* * * * * php artisan schedule:run` |

**Development `.env`:**
```env
QUEUE_CONNECTION=sync
```

**Production `.env`:**
```env
QUEUE_CONNECTION=custom-database
```

**Catatan penting:**
- Tidak perlu setup Redis untuk fitur ini. Queue driver `custom-database` yang sudah ada sudah cukup.
- Email submission confirmation tetap melalui `dispatch()` → masuk `tr_job_queue` → diproses oleh scheduler.
- GDrive/Google Sheets operations berjalan **synchronous** (tidak di-queue) untuk simplicity.

---

### 48.2 Integrasi dengan Job Queue Log

Email yang dikirim setelah user submit form akan menggunakan infrastruktur email yang **sudah ada**:
- `SendSingleMailJob` — job yang sudah exist untuk mengirim satu email
- `dispatch(new SendSingleMailJob($email, $mailable))` — otomatis masuk ke `tr_job_queue`
- Admin dapat memantau status pengiriman email di **Job Queue Log** admin page (sudah ada)
- Tidak perlu perubahan pada sistem job queue yang sudah ada

```
User Submit Form
      ↓
FormSubmissionController::store()
      ↓
MsForm::processSubmission()   ← business logic di model/service
      ↓
[Sync] Append ke Google Sheets
[Sync] Upload file ke GDrive (jika ada)
[Sync] Insert tr_form_submission ke DB
      ↓
[Queued] dispatch(new SendSingleMailJob(...))  → masuk tr_job_queue
      ↓
Scheduler (setiap menit) → queue:work → kirim email
      ↓
Admin bisa lihat status di /admin/email-config/job-queue-log
```

---

### 48.3 Vendor / Composer Packages

**Tidak ada package baru yang dibutuhkan.** Semua sudah tersedia:

| Package | Status | Kegunaan |
|---|---|---|
| `google/apiclient` | ✅ Already installed | Google Drive API + Google Sheets API |
| `masbug/flysystem-google-drive-ext` | ✅ Already installed | GDrive file storage |
| `realrashid/sweet-alert` | ✅ Already installed | Admin notifications |
| `barryvdh/laravel-dompdf` | ✅ Already installed | PDF generation (future) |

**Yang perlu dijalankan di production setelah deployment:**
```bash
php artisan migrate
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

### 48.4 Code Architecture: Fat Model + Thin Controller

Seluruh implementasi mengikuti prinsip:

```
┌─────────────────┐    ┌───────────────────────┐    ┌─────────────────────┐
│   Controller    │───▶│   Model / Service     │───▶│    Database /       │
│  (thin layer)   │    │  (business logic)     │    │    Google Drive      │
│                 │◀───│                       │◀───│                      │
│ - validate      │    │ - queries             │    │                      │
│ - call model    │    │ - calculations        │    │                      │
│ - return view   │    │ - orchestration       │    │                      │
└─────────────────┘    └───────────────────────┘    └─────────────────────┘
```

**Aturan:**
- Controller **hanya** boleh: validate request → call model/service method → return view/json
- Semua query logic ada di Model (scope, static method, relationship)
- Complex orchestration (GDrive + Sheets + Email) ada di `DynamicFormGDriveService`
- Tidak ada business logic di controller

**Contoh pola:**
```php
// ✅ BENAR — Controller thin
public function store(StoreFormRequest $request)
{
    $form = MsForm::createFromRequest($request, auth()->user());
    Alert::success('Berhasil', 'Form berhasil dibuat.');
    return redirect()->route('admin.forms.show', $form->formID);
}

// ❌ SALAH — Business logic di controller
public function store(Request $request)
{
    $form = new MsForm();
    $form->title = $request->title;
    $form->slug = Str::slug($request->title);
    // ... logic panjang
    $form->save();
}
```

---

### 48.5 Production Hosting (Domainesia)

- **Tipe hosting:** Shared hosting (Domainesia)
- **Cron job:** Sudah dikonfigurasi via cPanel untuk `schedule:run`
- **Queue worker:** Dijalankan via `queue:work --stop-when-empty` di dalam scheduler (sudah ada di `Kernel.php`)
- **Tidak diperlukan:** VPS, Supervisor, Systemd, Redis
- **PHP version:** Sesuaikan dengan yang tersedia di panel Domainesia

**Catatan deployment:**
```
1. Upload/push code ke production
2. Jalankan: php artisan migrate
3. Jalankan: php artisan config:clear && php artisan view:clear
4. Pastikan QUEUE_CONNECTION=custom-database di .env production
5. Cron job sudah berjalan otomatis via cPanel
```

---

### 48.6 Public Form UI Theme

Public form menggunakan **tema yang sama dengan halaman auth** (`resources/views/auth/`).

**CSS classes yang digunakan:**
```html
<!-- Form card wrapper -->
<div class="auth-card">

  <!-- Card header -->
  <div class="auth-card-header">
    <div class="auth-card-icon"><i class="fas fa-wpforms"></i></div>
    <div class="auth-card-title">{{ $form->title }}</div>
    <div class="auth-card-subtitle">{{ $form->description }}</div>
  </div>

  <!-- Input fields (text, email, etc.) -->
  <div class="auth-input-wrap">
    <div class="form-floating">
      <input type="text" class="form-control has-icon" placeholder="...">
      <label class="has-icon">Label</label>
      <i class="fas fa-user auth-input-icon"></i>
    </div>
  </div>

  <!-- Submit button -->
  <button type="submit" class="auth-btn">
    <i class="fas fa-paper-plane"></i>
    <span>Kirim Formulir</span>
    <div class="auth-btn-shine"></div>
  </button>

</div>
```

**Tambahan untuk field types lain:**
- `textarea`: `form-control` tanpa `form-floating`, dengan `.auth-input-wrap` wrapper
- `select`: `form-select` dengan `.auth-input-wrap` wrapper
- `radio/checkbox`: `.form-check` group dalam `.auth-input-wrap`
- `file`: custom upload area dengan `.auth-input-wrap`

---

### 48.7 Responsive + Dark Mode + Lightweight

**Responsive:**
- Bootstrap 5 grid (`col-12 col-md-8 col-lg-6` untuk form container)
- Form full-width di mobile (≤ 767px)
- Multi-column layout di desktop untuk section-based forms

**Dark Mode:**
- Menggunakan CSS variables yang sudah ada di project
- Mengikuti pola `prefers-color-scheme: dark` yang sudah ada di auth pages
- Tidak menambahkan library baru

**Lightweight:**
- Tidak menggunakan heavy builder library (no jQuery UI, no Quill, no Vue)
- Alpine.js untuk interactivity (sudah ada di project)
- SortableJS untuk drag-drop field ordering (CDN, ~25KB)
- Native `<input type="file">` dengan preview via FileReader API
- Tidak ada build step (no webpack/vite untuk fitur ini)

---

### 48.8 Email Field Mandatory

Setiap form memiliki **satu email field yang wajib ada** dan **tidak dapat dihapus** oleh admin.

**Aturan:**
1. Saat admin membuat form baru, system otomatis insert 1 field email di posisi pertama (sortOrder = 0)
2. Field ini memiliki flag `isSystemField = true` (atau `fieldType = 'email'` + `flagActive = true` + tidak boleh dihapus)
3. Di form builder UI, field email ditampilkan dengan label "Locked" / tidak ada tombol delete
4. Validasi di server: jika field email tidak ada di submission, tolak

**Alur setelah submission:**
```
User isi form (termasuk field email wajib)
      ↓
Server validasi + anti-spam check
      ↓
Append ke Google Sheets
      ↓
Insert tr_form_submission ke DB
      ↓
dispatch SendFormConfirmationMail ke email user
(via SendSingleMailJob → tr_job_queue)
```

**Isi email konfirmasi:**
- Subject: `Konfirmasi: {Form Title}`
- Body: Daftar semua jawaban user dalam format tabel
- Footer: Link ke website LDK Syahid

**Model field email system (disimpan di `ms_form_field`):**
```json
{
  "fieldType": "email",
  "label": "Alamat Email",
  "placeholder": "nama@contoh.com",
  "isRequired": true,
  "isSystemField": true,
  "sortOrder": 0,
  "validation": {
    "rules": ["required", "email", "max:255"]
  }
}
```

---

### 48.9 Admin Creator Auto-Gets GDrive Editor Access

Saat admin membuat form baru, **email admin yang membuat form** otomatis ditambahkan sebagai Editor di folder GDrive form tersebut — sama seperti collaborator email yang diisi manual.

**Urutan permission setup saat `setupFormFolder()` dipanggil:**
1. Buat folder `{Form Title}/` di dalam `dynamic_form/` root
2. Buat Google Spreadsheet di dalam folder
3. Buat subfolder `attachments/` + per-field subfolders
4. Grant Editor access ke:
   - `auth()->user()->email` ← admin yang membuat form (**OTOMATIS**)
   - Email-email dalam `collaboratorEmails` ← diisi manual oleh admin

**Catatan:**
- Service Account yang digunakan oleh aplikasi tetap sebagai owner
- Admin dan collaborator mendapat role `writer` (bisa edit, tidak bisa manage permissions)
- Jika admin mengedit form, email tidak di-update ulang (sudah punya akses)
- Jika collaborator dihapus dari form, akses GDrive-nya juga dicabut

---

### 48.10 Database Column: isSystemField

Tambahkan kolom `isSystemField` ke tabel `ms_form_field`:

| Column | Type | Default | Deskripsi |
|---|---|---|---|
| `isSystemField` | `TINYINT(1)` | `0` | `1` = field yang tidak bisa dihapus admin (misal: field email wajib) |

**Update di migration `ms_form_field`:**
```php
$table->boolean('isSystemField')->default(false)->comment('1 = system-generated field, cannot be deleted');
```

---

### 48.11 Summary Perubahan pada Planning Document

| Bagian | Perubahan |
|---|---|
| Section 5.2 (`ms_form_field`) | Tambah kolom `isSystemField` |
| Section 10 (Submission Flow) | Update Step 5: tambah email confirmation dispatch |
| Section 13 (File Upload) | Update: admin creator email auto-added to GDrive |
| Section 47.3 (Queue Setup) | Update: dev gunakan `QUEUE_CONNECTION=sync` |
| Section 47.6 (Env Vars) | Update: tambahkan env var contoh untuk dev vs prod |
| Section 48 (NEW) | Semua confirmed decisions sebelum implementasi |

---

*Document End*

> **Next Step:** Implementation telah dimulai. Development mengikuti urutan: Migrations → Models → Services → Controllers → Routes → Views.

> **Contact:** Development Team - LDK Syahid App
