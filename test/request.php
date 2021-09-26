<?php

    include  '../vendor/autoload.php';

    use Mhmmdq\Zarinpal\Zarinpal;

    $zarinpal = new Zarinpal('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' , 10000 , 'http://localhost/zarinpal-payment-class/verify.php' , 'یک پرداخت برای تست کلاس پرداخت با زرین پال' , ['name' => 'mhmmdq']);

    