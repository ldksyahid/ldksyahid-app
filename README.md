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
<img src="https://img.shields.io/badge/version-v1.0.0-blue" />
<img src="https://img.shields.io/badge/license-LDK Syahid-green" />
<img src="https://img.shields.io/badge/contributors-11-brightgreen" />
</div>

## System Requirement
**System Operations :** Windows or Unix Base

**PHP** >= 7.4.27

**Xampp** >= 3.3.0

**Composer** = 2.5.5

**Laravel** = 8.x

**Node JS** = 8.15.0

**Git** = 2.33.1

## Development Setup

### Prerequisites
<ul>
    <li><a href="https://code.visualstudio.com/download" target="_blank" rel="noopener noreferrer">Visual Studio Code</a></li>
    <li><a href="https://windows.php.net/download#php-7.4" target="_blank" rel="noopener noreferrer">PHP 7.4.27</a></li>
    <li><a href="https://www.apachefriends.org/download.html" target="_blank" rel="noopener noreferrer">XAMPP</a></li>
    <li><a href="https://getcomposer.org/download/" target="_blank" rel="noopener noreferrer">Composer</a></li>
    <li><a href="https://nodejs.org/en/download" target="_blank" rel="noopener noreferrer">Node JS</a></li>
    <li><a href="https://git-scm.com/downloads" target="_blank" rel="noopener noreferrer">Git</a></li>
</ul>

### Setting Up a Project
<b>Clone the project</b>
<br>
```bash
git clone https://github.com/ldksyahid/ldksyahid-app.git
```

<b>Create 2 new schema</b> 
<br>
Open MySQL Workbench and create 2 schema:  
<ol>
    <li>fnb_sbux_4</li>
    <li>fnb_sbux_2</li>
</ol>

<b>Configuration</b>
<br>
Create the following file for local environment configuration:  
- `starbucks-pos/api/config/db.php`
- `starbucks-pos/frontend/src/assets/params.json`

```php
<?php 
        
return [
    'dbMain' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1:3306;dbname=fnb_sbux_4',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1:3306;dbname=fnb_sbux_2',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ]
];
```
```json
{
  "httpBaseUrl": "http://localhost:82/starbucks-pos/api/web/v1",  //adjust localhost port with php version >= 7.2.11
  "webSocketUrl": "ws://localhost:8081"
}
```
<b>Migration</b>
<br>
Run Migration in directory `starbucks-pos/api`
```bash
php yii migrate
```
<b>Node Modules</b>
<br>
Install node_modules in directory `starbucks-pos/frontend`
```bash
npm install
```
<b>Run the project</b>
<br>
Run in directory `starbucks-pos/frontend`
```bash
npm start
```
or
```bash
ng serve
```

### Usage a Project
<b>1. Run the project</b> 
<br>

<b>2. Change link to install </b> 
<br>
Change to `http://localhost:4500/install`
<br>

<b>3. Input and Submit</b> 
<br>
<ul>
    <li>
        API URL : http://localhost/starbucks-backend
        <br>
        The API URL is obtained from the localhost <a href="https://gitlab.esb.co.id/custom/starbucks/starbucks-backend" target="_blank" rel="noopener                 noreferrer">starbucks-backend</a> link 
    </li>
    <li>
        API Key : authsci
        <br>
        The API Key can be obtained from the contents of the companyAuthKey column in the <a href="https://gitlab.esb.co.id/custom/starbucks/starbucks-backend"         target="_blank" rel="noopener noreferrer">starbucks-backend</a> database
    </li>
    <li>
        Branch : STARBUCKS KOTA HARAPAN INDAH
        <br>
        You can choose freely but we recommend choosing that branch
    </li>
</ul>
You can run SQL Script for obtained API Key

```sql
select companyAuthKey from esb_main_sbux.ms_company;
```

<b>4. Set terminalID</b> 
<br>
add this `?terminalID=GK01-001` to the link `http://localhost:4500/login` so it becomes `http://localhost:4500/login?terminalID=GK01-001`

<b>5. Login</b> 
<br>
You must have a <a href="https://gitlab.esb.co.id/custom/starbucks/starbucks-backend" target="_blank" rel="noopener        noreferrer">starbucks-backend</a> account first
<br>
Login with the PIN that was created in the previous <a href="https://gitlab.esb.co.id/custom/starbucks/starbucks-backend" target="_blank" rel="noopener        noreferrer">starbucks-backend</a> project
<br>
If you can't login POS, please sync first

<b>6. Setup Cash Drawer</b> 
<br>
Run SQL Script to add Cashdrawer in MySQL Workbench
```sql
INSERT INTO `fnb_sbux_2`.`ms_cashdrawer` (`cashDrawerID`, `cashDrawerName`, `createdDate`, `editedBy`, `editedDate`) VALUES (NULL, 'CDN-01', NULL, NULL, NULL);
```
Then Assign Cashdrawer in POS

<b>7. Finally, you can use Starbucks POS ^_^</b> 

## Version
| Version | Date         | Update |
| :---:   |     :---:    |  ---   |
| `1.0.0`| `2022-12-22` | <ul><li>Initial Version</li></ul> |
