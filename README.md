# Compolom Tools Kmail

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)
[![downloads](https://poser.pugx.org/compolomus/kmail/downloads)](https://packagist.org/packages/compolomus/kmail)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/kmail/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/kmail/?branch=master)

## Установка:

composer require compolomus/kmail


## Применение:

```php

use Compolomus\Kmail;

$test = new KMail('Test text');
$test
    ->addAdress('test@mail.ru')
    ->addAdress('test@gmail.com')
    ->addFile('class.php', file_get_contents(__FILE__))
    ->setSubject('Test mail')
    ->send();
$test->debug();

```

