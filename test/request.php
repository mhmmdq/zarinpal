<?php

    include  '../vendor/autoload.php';

    use Mhmmdq\Zarinpal\Zarinpal;
    
    $merchant = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
    $amount = 200000;
    $callback_url = 'https://zarinpal.mhmmdq.ir/verify.php';
    $description = 'توضیحات پرداخت';
    $metadata = ['name' => 'mhmmdq'];

    $zarinpal = new Zarinpal($merchant , $amount , $callback_url , $description , $metadata);

    $zarinpal->PayMentPortal();
    