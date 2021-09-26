<?php

    include  './vendor/autoload.php';

    use Mhmmdq\Zarinpal\Zarinpal;

    $zarinpal = new Zarinpal('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx' , 10000);

    var_dump($zarinpal->PayMentVerify());