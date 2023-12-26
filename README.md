# LDK Syahid Web App
<div align="center" style='text-align : center;'>
  <div class="row">
  <img src="https://laravel.com/img/logomark.min.svg" width="100px">
  </div>
  <br>
  <img src="public/Images/Logos/logoldksyahid.png" alt="ldk-logo" width="250px"/>
  <br>
  <i>#KitaAdalahSaudara</i>
  <br>
</div>

<br>
<div align="center">
<img src="https://img.shields.io/badge/version-v1.2.0-blue" />
<img src="https://img.shields.io/badge/license-LDK Syahid-green" />
<img src="https://img.shields.io/badge/contributors-11-brightgreen" />
</div>

## System Requirement
**System Operations :** Windows or Unix Base

**PHP** >= 7.4

**Xampp** >= 3.3.0

**Composer** = 2.5.5

**Laravel** = 8.x

**Node JS** = 8.15.0

**Git** = 2.33.1

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

### Setting Up a Project
<b>Clone the project</b>
<br>
Run in the directory is up to you
<br>
```bash
git clone https://github.com/ldksyahid/ldksyahid-app.git
```

<b>Create Database</b> 
<br>
<ol>
    <li>Run Module Apache and MySQL in xampp and open PHPMyAdmin</li>
    <li>Create New Schema <b>ldksyahid_db</b></li>
</ol>

<b>.env</b> 
<br>
<ol>
    <li>Copy paste ".env.example" and rename to ".env"</li>
    <li>Adjust the database connection environment to the schema you have created</li>
</ol>

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ldksyahid_db
DB_USERNAME=root
DB_PASSWORD=
```

<b>Composer</b>
<br>
Run Composer Install in directory `ldksyahid-app/`
```bash
composer install
```

<b>Migration</b>
<br>
Run migrations in directory `ldksyahid-app/`
```bash
php artisan migrate
```

<b>Seeder</b>
<br>
Run Seeder in directory `ldksyahid-app/`
```bash
php artisan db:seed --class=CreateUsersSeeder
```
```bash
php artisan db:seed --class=PermissionSeeder
```
```bash
php artisan laravolt:indonesia:seed
```

<b>Node Modules</b>
<br>
Install node_modules in directory `ldksyahid-app/`
```bash
npm install
```

<b>Generate Key</b> 
<br>
Run in directory `ldksyahid-app/`
<br>
```bash
php artisan key:generate
```

<b>Run the project</b>
<br>
Run in directory `ldksyahid-app/`
```bash
php artisan serve
```

### Usage a Project
<b>1. Run the project</b> 
<br>

<b>2. Login</b> 
<br>
<ul>
    <li>Email : admin@ldksyah.id</li>
    <li>Password : admin</li>
</ul>

<b>3. Finally, have fun ^_^</b> 
<br>

## Version
| Version | Date         | Update |
| :---:   |     :---:    |  ---   |
| `1.2.0`| `2023-12-26` | <ul><li>Addition and adjustment of the Machine Learning Donation Celshahid Dashboard Feature</li></ul> |
| `1.1.0`| `2023-10-25` | <ul><li>Add KTA LDK Syahid Feature</li><li>New Mobile Responsive CMS Admin</li></ul> |
| `1.0.3`| `2023-09-28` | <ul><li>Add Ekspresi Content and Develop Celsyahid Machine Learning</li></ul> |
| `1.0.2`| `2023-07-22` | <ul><li>Update Notify Celengan Syahid</li></ul> |
| `1.0.1`| `2023-05-28` | <ul><li>Revamp Admin Form</li></ul> |
| `1.0.0`| `2022-12-22` | <ul><li>Initial Version</li></ul> |
