<?php

require('../src/Tools/Kmail.php');

$test = new KMail('Test');
$test
    ->addArdess('compolom@gmail.com')
    ->addArdess('test@gmail.com')
    ->addFile('class.php', file_get_contents(__FILE__))
    ->setSubject('Test mail')
    ->send();
$test->debug();