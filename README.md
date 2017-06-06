# Compolom Tools Kmail

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Compolomus/kmail/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Compolomus/kmail/?branch=master)

## Применение:

```php

use Compolom\Tools;

$test = new KMail('Test text');
$test
    ->addAdress('test@mail.ru')
    ->addAdress('test@gmail.com')
    ->addFile('class.php', file_get_contents(__FILE__))
    ->setSubject('Test mail')
    ->send();
$test->debug();

```

