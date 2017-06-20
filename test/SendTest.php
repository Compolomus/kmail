<?php

use Compolomus\Kmail\Kmail;

require '../vendor/autoload.php';

$test = new KMail('Test text');
$test
    ->addAdress('test@mail.ru')
    ->addAdress('test@gmail.com')
    ->addFile('class.php', file_get_contents(__FILE__))
    ->setSubject('Test mail')
    ->send();
$test->debug();
