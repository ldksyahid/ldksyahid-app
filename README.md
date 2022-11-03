<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Installation ldkshayid-app

### 1. Clone git to Local Folder
```
git clone https://github.com/My-Dios/ldksyahid-app.git
```

### 2. Install Composer
```
composer install
```

### 3. Add .env
copy paste ".env.example" and rename to ".env"

### 4. Generate Key
```
php artisan key:generate
```

### 5. Configuration .env
edit .env db_database same with your db created (you must create db from like mysql) and email for notification from email
```
DB_HOST=localhost
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=yourcodepassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="yourname"
```
### 6. Edit File VerifyEmail.php
Open File in vendor/laravel/framework/src/Illuminate/Auth/Notifications/VerifyEmail.php 

Add use
```
use Illuminate\Support\HtmlString;
```
Change Code in Function buildMailMessage($url)
```
 protected function buildMailMessage($url)
    {
        return (new MailMessage)
        ->greeting(Lang::get("Assalammu'alaikum Sobat Syahid 😊"))
        ->subject(Lang::get('Verifikasi Alamat Email Untuk Daftar Akun Website UKM LDK Syahid'))
        ->line(Lang::get("Silahkan Klik Tombol di bawah ini untuk Memverifikasi Alamat Email"))
        ->action(Lang::get('Verifikasi Alamat Email'), $url)
        ->line(Lang::get("Verifikasi Email ini dilakukan untuk Menghindari Penyalahgunaan Akun"))
        ->salutation(new HtmlString("<br><br>Wassalammu'alaikum 😊<br><br> Salam Semangat,<br>Admin Website UKM LDK Syahid UIN Jakarta"));
    }
```

### 7. Edit File ResetPassword.php
Open File in vendor/laravel/framework/src/Illuminate/Auth/Notifications/ResetPassword.php

Add Use 
```
use Illuminate\Support\HtmlString;
```
Change Code in Function buildMailMessage($url)
```
 protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->greeting(Lang::get("Assalammu'alaikum Sobat Syahid 😊"))
            ->subject(Lang::get('Notifikasi Reset Password'))
            ->line(Lang::get('Kamu Menerima Email ini karena Kami Menerima Permintaan untuk Mereset Password Akun Kamu'))
            ->action(Lang::get('Reset Password'), $url)
            ->line(Lang::get('Link Reset Password ini akan berakhir dalam :count Menit', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Jika Kamu tidak Meminta Reset Password, Maka tidak ada Tindakan lebih lanjut yang perlu Kamu lakukan'))
            ->salutation(new HtmlString("<br><br>Wassalammu'alaikum 😊<br><br> Salam Semangat,<br>Admin Website UKM LDK Syahid UIN Jakarta"));
    }
```

### 8. Migrate Database
```
php artisan migrate
```

### 9. Migrate Seed DB
```
php artisan db:seed --class=CreateUsersSeeder
```

### 10. Run Application
```
php artisan serve
```


