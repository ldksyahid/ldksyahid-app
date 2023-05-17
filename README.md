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
**System Operations:** Windows or Unix Base

**PHP:** >= 7.2.11

**MySQL:** 5.6

**NodeJS:** >= 18.4.1

## Development Setup

### Prerequisites
<ul>
    <li><a href="https://code.visualstudio.com/download" target="_blank" rel="noopener noreferrer">Visual Studio Code</a></li>
    <li><a href="https://docs.google.com/document/d/10Xvm_m-IcQFSjnP-zyUdUItCayjlEMzU/edit?usp=sharing&ouid=101904115063108684048&rtpof=true&sd=true" target="_blank" rel="noopener noreferrer">Apache24 Web Server</a></li>
    <li><a href="https://docs.google.com/document/d/14UVW91EwH2znZdFcBIESF9zNCw23diPG/edit?usp=sharing&ouid=101904115063108684048&rtpof=true&sd=true" target="_blank" rel="noopener noreferrer">Node JS & Angular</a></li>
    <li><a href="https://www.freecodecamp.org/news/node-version-manager-nvm-install-guide/" target="_blank" rel="noopener noreferrer">NVM</a></li>
    <li><a href="https://dev.mysql.com/downloads/workbench/" target="_blank" rel="noopener noreferrer">MySQL Workbench</a></li>
    <li><a href="https://gitlab.esb.co.id/custom/starbucks/starbucks-backend" target="_blank" rel="noopener noreferrer">starbucks-backend</a></li>
</ul>

### Setting Up a Project
<b>Clone the project</b>
<br>
clone into directory `C:\Apache24\htdocs`
```bash
git clone https://gitlab.esb.co.id/custom/starbucks/starbucks-pos.git
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

## Drive Thru Mode
Make sure you must have a different web browser, and run this link in every different browser
### Order Display Only
`http://localhost:4500/login?terminalID=GK01-001&driveThruMode=order`
### Payment Display Only
`http://localhost:4500/login?terminalID=GK01-001&driveThruMode=payment`
### Order & Payment Display
`http://localhost:4500/login?terminalID=GK01-001&driveThruMode=orderpayment`

## Version
| Version | Date         | Update |
| :---:   |     :---:    |  ---   |
| `1.7.9` | `2023-05-08` | <ul><li>Fixing bugs empty bill number on non sales drive thru mode</li><li>Fixing bugs rewards can be applied on cancelled menu</li><li>Fixing bugs calculation on take off overwrite promo</li><li>Add multiple apply promo validation</li><li>Add duplicate sales payment data validation</li><li>Auto sync pos version</li></ul> |
| `1.7.8` | `2023-04-18` | <ul><li>Hotfix fix API Version MAP</li></ul> |
| `1.7.7` | `2023-04-13` | <ul><li>Fixing bugs on Empty PLU Menu Combination When Apply Promotion</li><li>Optimize Print Payment</li><li>Enhance Save Cross Sales Date and Empty BillNum</li></ul> |
| `1.7.6` | `2023-03-23` | <ul><li>Fixing bugs on re-apply Starbucks Rewards</li><li>Fixing bugs ODS on menu cancel</li><li>Fixing bugs calculate promo</li></ul> |
| `1.7.5` | `2023-03-15` | <ul><li>Validation on Save Payment to Prevent Double Deduct on Starbucks Card</li><li>Print Top Up Receipt as Failed to Get Latest Balance</li><li>Fixing angular component not implement <b>OnDestroy</b></li></ul> |
| `1.7.4` | `2023-02-28` | <ul><li>Enhance auto sync & auto sync sales</li></ul> |
| `1.7.3` | `2023-02-23` | <ul><li>Change label</li></ul> |
| `1.7.2` | `2023-02-21` | <ul><li>Bugfix when top up failed reload balance, add button reload balance</li><li>Bugfix ECR BCA for next payment</li><li>Bugfix multiple print at same transactions</li><li>Clear sales local storage on home payment</li></ul> |
| `1.7.1` | `2023-01-17` | <ul><li>Hotfix edc top up bca</li></ul> |
| `1.7.0` | `2023-01-12` | <ul><li>Decoupling payment and top up sbux card</li><li>ECR BCA</li><li>Print image in printer star SM-T300i</li><li>Customer voice not print in non sales transaction</li><li>Printing label for reserved outlet set by station or by head menu itself</li><li>Bug fix: Rewards not deducting grand total, rounding, unlock offer when cancel menu, payment more than grand total</li></ul> |
| `1.6.5` | `2022-12-14` | <ul><li>Improved sbuxcard rewards validation</li></ul> |
| `1.6.4` | `2022-12-13` | <ul><li>Fixed the issue of entertainment transactions</li><li>Improvements to the issue of the curly grand total number on the employee discount</li><li>Fixed the hide Customer Code issue</li><li>API Kiosk & Integration POS to Queue Display</li><li>Inbound calculation improvements for employee discount transactions</li><li>Fixed issue report POS: summary report; report filters at 23:59</li><li>Starbucks card issue fix</li></ul> |
| `1.6.3` | `2022-10-17` | <ul><li>Improved employee discount for single menu</li></ul> |
| `1.6.2` | `2022-10-12` | <ul><li>Improved calculations when applying promotions and conditional promotions</li><li>Reporting improvements</li><li>Improvements to save orders in the drive thru</li><li>Customer display repair</li><li>Fixed an error when placing an order</li></ul> |
| `1.6.1` | `2022-08-29` | <ul><li>Logging update sync</li><li>Promo improvements on Drive Thrue, Bill Discount, Discount Menu with scenarios of adding and removing items repeatedly</li><li>Fixed Payment being disabled when using a specific payment method when deleting all menus</li><li>Improved vat calculation for promo session M</li></ul> |
| `1.6.0` | `2022-08-22` | <ul><li>PoS PPN 11% Version</li><li>Bug fixing for promotions</li></ul> |
| `1.5.7` | `2022-07-25` | <ul><li>Change method sync to zip</li></ul> |
| `1.5.6` | `2022-07-13` | <ul><li>Fixing issue payment zero</li></ul> |
| `1.5.5` | `2022-07-06` | <ul><li>Change format logDesc and externalMemberId to utf8</li></ul> |
| `1.5.4` | `2022-07-03` | <ul><li>Separate payment with difference API</li><li>ixing payment if sbuxcard balance is zero</li></ul> |
| `1.5.3` | `2022-06-28` | <ul><li>Fixing brand ID on MAP Voucher</li></ul> |
| `1.5.2` | `2022-06-27` | <ul><li>Fixing Lock Offer Multiple Qty</li></ul> |
| `1.5.1` | `2022-06-27` | <ul><li>Move MAP API to core</li><li>Fixing CV from branch id to branch code</li></ul> |
| `1.5.0` | `2022-06-23` | <ul><li>Rounding issue 7.5</li></ul> |
| `1.4.9` | `2022-06-14` | <ul><li>PoS Airport</li></ul> |
| `1.4.8` | `2022-06-17` | <ul><li>Auto Sync</li></ul> |
| `1.4.7` | `2022-06-13` | <ul><li>Fixing original price for inbound</li><li>Change tr pos log description datatype to text medium</li><li>Limit terminal id maximum 8 characters</li><li>Fixing refTempNum kebawa ke next transactions</li></ul> |
| `1.4.6` | `2022-05-24` | <ul><li>Improvements to the Starbucks Card Activation process</li></ul> |
| `1.4.5` | `2022-05-24` | <ul><li>Changed Starbucks Card Payment retry from 3x to 5x</li></ul> |
| `1.4.4` | `2022-05-24` | <ul><li>Added Starbucks Card Activation transactions to the Topup Report</li><li>Optimization of the Starbucks Card Topup process</li></ul> |
| `1.4.3` | `2022-05-23` | <ul><li>POS version label fixes</li></ul> |
| `1.4.2` | `2022-05-23` | <ul><li>Fixed hide loading during the unlock offer process</li><li>Improvements to the clear subject starbucks card when the process selects a non-main visit purpose</li></ul> |
| `1.4.1` | `2022-05-19` | <ul><li>Optimization of the POS retry process when calling the external API</li><li>Optimization of the lock offer process handle for multiple reward items</li></ul> |
| `1.4.0` | `2022-05-13` | <ul><li>Added retry process to POS when calling external API</li></ul> |
| `1.3.1` | `2022-05-11` | <ul><li>Improvement of printing payment when finished on ODS</li><li>Fixed the payment code on tr_saleshead for Drive Thru mode</li></ul> |
| `1.3.0` | `2022-04-29` | <ul><li>Limit applying rewards and promotions simultaneously</li><li>Added a scroll to the reward list</li></ul> |
| `1.2.5` | `2022-04-29` | <ul><li>Optimize delete local storage</li></ul> |
| `1.2.4` | `2022-04-27` | <ul><li>Improvement of the sbux card top up with the cash payment method and Mobile POS mode</li><li>Optimization of the clear local storage process for order lists</li></ul> |
| `1.2.3` | `2022-04-26` | <ul><li>Improvements to the drive thru order</li><li>Drive thru save order fix</li><li>Improvement of the 11% VAT recalculation process</li></ul> |
| `1.2.2` | `2022-04-22` | <ul><li>Optimization of the sbux card activation process</li><li>Fixed issue of payment & send to kitchen disabled after finishing order on ODS</li></ul> |
| `1.2.1` | `2022-04-20` | <ul><li>Optimization of the fetch package menu process</li></ul> |
| `1.2.0` | `2022-04-19` | <ul><li>Changing the font size for additional and qty menus</li><li>Added an open cash drawer method with a printer connection</li><li>Optimization of the customer display</li><li>Perbaikan API Get Order ODS</li></ul> |
| `1.1.0` | `2022-04-16` | <ul><li>Added additional offer lock feature</li><li>Optimization of the MAP Voucher burning process</li><li>Optimization of SessionM API call process</li><li>Master Menu Combination indexing optimization</li></ul> |
| `1.0.18`| `2022-04-10` | <ul><li>Improvement apply discount</li></ul> |
| `1.0.17`| `2022-04-10` | <ul><li>Initial Version</li></ul> |
