<img src="https://repository-images.githubusercontent.com/410418462/1f0e17c2-0624-4d78-afd8-7c44a2195af9" width="100%">

# کلاس پرداخت با [زرین پال](https://zarinpal.com "ZarinPal")
یک کلاس برای ساده کردن عملیات پرداخت و تأیید پرداخت خدمات درگاه پرداخت زرین پال

## نصب و استفاده

### نصب با کامپوزر
composer require mhmmdq/zarinpal 

با دستور بالا به راحتی کلاس را به پروژه خود اضافه کنید

### استفاده
در ابتدا اوتولودر کامپوزر را فراخوانی کنید و کلاس را صدا بزنید
```php
<?php

include 'vendor/autoload.php';
use Mhmmdq\Zarinpal\Zarinpal;
```
یک شی از کلاس بسازید و مقادیر مورد نیاز رو تنظیم کنید

`$merchant` کدی که از زرین پال دریافت میکنید

`$amount` مقداری که باید پرداخت شود

`$callback_url` مکانی که پس از پرداخت باید به انجا هدایت شود

`$description` توضیحات پرداخت

`$metadata` ارایه ای از هرچیز که نیاز دارید پس از پرداخت ببینید

```php
<?php
include  'vendor/autoload.php';

use Mhmmdq\Zarinpal\Zarinpal;

$merchant = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
$amount = 200000;
$callback_url = 'https://zarinpal.mhmmdq.ir/verify.php';
$description = 'توضیحات پرداخت';
$metadata = ['name' => 'mhmmdq'];

$zarinpal = new Zarinpal($merchant , $amount , $callback_url , $description , $metadata);

    
```

و در اخر میتوانید با استفاده از متد رو به کاربر را به درگاه هدایت کنید  `PayMentPortal()`
```php
$zarinpal = new Zarinpal($merchant , $amount , $callback_url , $description , $metadata);
$zarinpal->PayMentPortal();
```
**اگر نمیخواهید کاربر به صورت خودکار هدایت شود میتوانید از رش زیر استفاده کنید**
```php
$zarinpal = new Zarinpal($merchant , $amount , $callback_url , $description , $metadata);
$zarinpal->PayMentPortal(false);
```

##### تایید پرداخت

برای انجام فرایند تایید پرداخت روش زیر را استفاده کنید

```php
<?php

include  'vendor/autoload.php';

use Mhmmdq\Zarinpal\Zarinpal;

$zarinpal = new Zarinpal('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' , 200000);

var_dump($zarinpal->PayMentVerify());
```
اگر پرداخت موفقیت امیز باشد در ارایه بازگشتی کلیدی به عنوان `status` با مقدار `success` وجود خواهد داشت

### ارور ها
تمامی ارور هایی که پس یا بعد از فرایند پرداخت توسط سرویس زرین پال ارسال میشود در صورت وجود در ارایه ای با کلید  `errors` در دسترس قرار میگیرد

### مثال سیستم پرداخت
به زودی یک مثال کامل قرار خواهم داد
