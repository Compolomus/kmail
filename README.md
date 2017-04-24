# Compolom Tools Kmail

[![License](https://img.shields.io/badge/license-GPL%20v.3-blue.svg?style=plastic)](https://www.gnu.org/licenses/gpl-3.0-standalone.html)

## Применение:

```php

namespace Compolom\Tools;

require('../src/Tools/Kmail.php');

$test = new KMail('Test text');
$test
    ->addArdess('test@mail.ru')
    ->addArdess('test@gmail.com')
    ->addFile('class.php', file_get_contents(__FILE__))
    ->setSubject('Test mail')
    ->send();
$test->debug();

```

