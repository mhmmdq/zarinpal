<img src="https://repository-images.githubusercontent.com/410418462/1f0e17c2-0624-4d78-afd8-7c44a2195af9" width="100%">
# Payment class with [ZarinPal](https://zarinpal.com "ZarinPal")
A class to simplify payment operations and confirm payment of ZarrinPal payment gateway service ( [به فارسی بخوانید](./README-FA.md "به فارسی بخوانید") )

## Installation and use

### Installation with Composer
    composer require mhmmdq/zarinpal 

Easily add a class to your project using the command above

### use
First, call the composer autoloader and call the class
```php
<?php

include 'vendor/autoload.php';
use Mhmmdq\Zarinpal\Zarinpal;
```
Build an object and enter the required values

`$merchant` You will receive a code from ZarinPal

`$amount` Amount to be paid

`$callback_url` The place to return after the operation

`$description` Payment description

`$metadata` Get a presentation of everything you need after a successful payment

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

And at the end of the transfer to the payment gateway with method `PayMentPortal()`
```php
$zarinpal = new Zarinpal($merchant , $amount , $callback_url , $description , $metadata);
$zarinpal->PayMentPortal();
```
**If you do not want the transfer to be done automatically by the class, do the following**
```php
$zarinpal = new Zarinpal($merchant , $amount , $callback_url , $description , $metadata);
$zarinpal->PayMentPortal(false);
```

##### Payment confirmation

To confirm the payment, just do the following and then you will have a presentation of the result

```php
<?php

include  'vendor/autoload.php';

use Mhmmdq\Zarinpal\Zarinpal;

$zarinpal = new Zarinpal('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' , 200000);

var_dump($zarinpal->PayMentVerify());
```
If the payment is successful, there will be a key return in the array as `status` with the value of `success`

### Errors
You will receive all the errors before and after the payment operation as an array and the key name will be `errors`

### Sample payment script
I will give a complete example soon
