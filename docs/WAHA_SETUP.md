# WAHA WhatsApp API — Panduan Setup

Dokumen ini menjelaskan cara menginstal dan mengonfigurasi WAHA sebagai gateway WhatsApp untuk aplikasi LDK Syahid.

---

## Daftar Isi

1. [Apa itu WAHA?](#apa-itu-waha)
2. [Setup di Lokal (Development)](#setup-di-lokal-development)
3. [Setup di VPS / Server Production](#setup-di-vps--server-production)
4. [Setup di Shared Hosting](#setup-di-shared-hosting)
5. [Konfigurasi Laravel](#konfigurasi-laravel)
6. [Penggunaan di Kode](#penggunaan-di-kode)
7. [Troubleshooting](#troubleshooting)

---

## Apa itu WAHA?

WAHA (WhatsApp HTTP API) adalah self-hosted gateway WhatsApp berbasis Docker.
Aplikasi ini mengirim pesan WhatsApp melalui HTTP API tanpa biaya per-pesan.

**Digunakan di aplikasi ini untuk:**
- Notifikasi request shortlink baru ke admin/operator
- Invoice donasi Celengan Syahid ke donatur
- Konfirmasi donasi berhasil ke donatur

---

## Setup di Lokal (Development)

### Prasyarat
Docker Desktop sudah terinstal dan berjalan.

### Langkah 1 — Pull image WAHA

```bash
docker pull devlikeapro/waha
```

### Langkah 2 — Generate API Key

```bash
docker run --rm -v "%USERPROFILE%\waha-env":/app/env devlikeapro/waha init-waha /app/env
```

Lihat isi file `.env` yang dihasilkan:

```bash
type %USERPROFILE%\waha-env\.env
```

Catat nilai `WAHA_API_KEY=...`

### Langkah 3 — Jalankan container WAHA

```bash
docker run -d ^
  --env-file "%USERPROFILE%\waha-env\.env" ^
  -v "%USERPROFILE%\waha-sessions":/app/.sessions ^
  -p 3000:3000 ^
  --name waha ^
  --restart unless-stopped ^
  devlikeapro/waha
```

### Langkah 4 — Scan QR Code

1. Buka browser → **http://localhost:3000/dashboard**
2. Login menggunakan kredensial dari file `.env` tadi
3. Klik **Start** pada session `default`
4. Scan QR Code dengan WhatsApp nomor pengirim (`+62 821-1493-9571`)
5. Tunggu status berubah menjadi **WORKING** ✅

### Langkah 5 — Isi `.env` Laravel

```env
WAHA_BASE_URL=http://localhost:3000
WAHA_API_KEY=xxxxxxxxxxxxxxxxxxxxxx
WAHA_SESSION=default
```

---

## Setup di VPS / Server Production

Gunakan cara ini jika server production adalah **VPS atau dedicated server** (ada akses root/SSH).

### Langkah 1 — Install Docker di server

```bash
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER
newgrp docker
```

### Langkah 2 — Generate API Key

```bash
mkdir -p ~/waha && cd ~/waha
docker run --rm -v $(pwd):/app/env devlikeapro/waha init-waha /app/env
cat ~/waha/.env
```

### Langkah 3 — Jalankan WAHA (hanya bisa diakses dari dalam server)

```bash
docker run -d \
  --env-file ~/waha/.env \
  -v ~/waha/sessions:/app/.sessions \
  -p 127.0.0.1:3000:3000 \
  --name waha \
  --restart always \
  devlikeapro/waha
```

> `127.0.0.1:3000` memastikan WAHA **tidak terbuka ke internet publik**, hanya bisa diakses dari dalam server itu sendiri.

### Langkah 4 — Scan QR via SSH Tunnel

Karena dashboard tidak bisa diakses langsung dari luar, gunakan SSH tunnel dari laptop:

```bash
# Jalankan di terminal laptop kamu
ssh -L 3000:127.0.0.1:3000 user@ip-server-kamu
```

Selama terminal SSH ini terbuka, buka browser → **http://localhost:3000/dashboard** → scan QR.

### Langkah 5 — Isi `.env` Laravel di server

```env
WAHA_BASE_URL=http://127.0.0.1:3000
WAHA_API_KEY=xxxxxxxxxxxxxxxxxxxxxx
WAHA_SESSION=default
```

---

## Setup di Shared Hosting

Shared hosting (cPanel, Niagahoster, Rumahweb, dll) **tidak mendukung Docker**.
Solusinya: jalankan WAHA di tempat lain, Laravel cukup memanggil API-nya.

```
[Shared Hosting — Laravel]  →  HTTP API  →  [VPS kecil — WAHA Docker]
```

### Opsi A — VPS terpisah (direkomendasikan)

1. Sewa VPS kecil (mulai ~$5/bulan), misalnya di DigitalOcean, Vultr, atau Hetzner
2. Ikuti langkah [Setup di VPS](#setup-di-vps--server-production) di VPS tersebut
3. Buka port 3000 di firewall VPS (khusus untuk IP shared hosting jika memungkinkan)
4. Isi `.env` Laravel di shared hosting:

```env
WAHA_BASE_URL=http://ip-vps-kamu:3000
WAHA_API_KEY=xxxxxxxxxxxxxxxxxxxxxx
WAHA_SESSION=default
```

### Opsi B — Ngrok (sementara / testing)

Cocok untuk testing saja, bukan untuk production jangka panjang.

```bash
# Di laptop / PC yang selalu nyala
ngrok http 3000
# Akan dapat URL seperti: https://xxxx.ngrok-free.app
```

```env
WAHA_BASE_URL=https://xxxx.ngrok-free.app
WAHA_API_KEY=xxxxxxxxxxxxxxxxxxxxxx
WAHA_SESSION=default
```

---

## Konfigurasi Laravel

### File `.env`

```env
WAHA_BASE_URL=http://127.0.0.1:3000
WAHA_API_KEY=xxxxxxxxxxxxxxxxxxxxxx
WAHA_SESSION=default
```

### Database (`ms_setting`)

Nomor tujuan notifikasi shortlink disimpan di tabel `ms_setting`:

| key1 | key2               | value1          |
|------|--------------------|-----------------|
| WAHA | Notif Shortlink To | 62895394755672  |

Untuk mengubah nomor tujuan, update langsung di database atau melalui panel admin.

### Jalankan migrasi (jika belum)

```bash
php artisan migrate
```

---

## Penggunaan di Kode

Service class: `app/Services/WahaWhatsapp.php`

```php
use App\Services\WahaWhatsapp;

// Kirim pesan bebas ke nomor manapun
WahaWhatsapp::sendText('+62895394755672', 'Halo dari LDK Syahid!');

// Notifikasi request shortlink baru ke admin
WahaWhatsapp::sendShortlinkRequestNotif([
    'name'        => 'Budi',
    'email'       => 'budi@email.com',
    'whatsapp'    => '+62812xxxxx',
    'defaultLink' => 'https://panjang.com/url',
    'customLink'  => 'https://ldksyah.id/budi',
    'note'        => 'Untuk keperluan acara...',
]);

// Invoice donasi ke donatur
WahaWhatsapp::sendDonationInvoice($data);

// Konfirmasi donasi berhasil ke donatur
WahaWhatsapp::sendDonationPaid($data);
```

---

## Troubleshooting

### Pesan tidak terkirim

1. Cek status session di dashboard: **http://localhost:3000/dashboard**
2. Jika status bukan `WORKING`, stop dan start ulang session, lalu scan QR lagi
3. Cek log Laravel: `storage/logs/laravel.log` — error dari WAHA dicatat di sana

### Container WAHA mati setelah restart server

Pastikan flag `--restart always` (VPS) atau `--restart unless-stopped` (lokal) dipakai saat menjalankan container.

Cek status container:
```bash
docker ps -a | grep waha
```

Jalankan ulang jika mati:
```bash
docker start waha
```

### Nomor sudah logout dari WhatsApp

Buka dashboard → stop session → start session → scan QR ulang.
Session data tersimpan di volume `~/waha/sessions`, jadi biasanya tidak perlu scan ulang kecuali nomor logout manual.
