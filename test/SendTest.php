<?php

use Compolomus\Kmail;

$test = new KMail('Test text');
$test
    ->addAdress('test@mail.ru')
    ->addAdress('test@gmail.com')
    ->addFile('class.php', file_get_contents(__FILE__))
    ->setSubject('Test mail')
    ->send();
$test->debug();
