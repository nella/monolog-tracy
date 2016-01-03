# [Tracy](https://tracy.nette.org) BlueScreen handler for [Monolog](https://github.com/Seldaek/monolog)

[![Build Status](https://img.shields.io/travis/nella/monolog-tracy/master.svg?style=flat-square)](https://travis-ci.org/nella/monolog-tracy)
[![Code Coverage](https://img.shields.io/coveralls/nella/monolog-tracy.svg?style=flat-square)](https://coveralls.io/r/nella/monolog-tracy)
[![SensioLabsInsight Status](https://img.shields.io/sensiolabs/i/b54adb11-771e-46c5-ba2a-fef5bc37d3c4.svg?style=flat-square)](https://insight.sensiolabs.com/projects/b54adb11-771e-46c5-ba2a-fef5bc37d3c4)
[![Latest Stable Version](https://img.shields.io/packagist/v/nella/monolog-tracy.svg?style=flat-square)](https://packagist.org/packages/nella/monolog-tracy)
[![Composer Downloads](https://img.shields.io/packagist/dt/nella/monolog-tracy.svg?style=flat-square)](https://packagist.org/packages/nella/monolog-tracy)
[![Dependency Status](https://img.shields.io/versioneye/d/user/projects/5688ba47eb4f470030000b3f.svg?style=flat-square)](https://www.versioneye.com/user/projects/5688ba47eb4f470030000b3f)
[![HHVM Status](https://img.shields.io/hhvm/nella/monolog-tracy.svg?style=flat-square)](http://hhvm.h4cc.de/package/nella/monolog-tracy)

## Installation

Using  [Composer](http://getcomposer.org/):

```sh
$ composer require nella/monolog-tracy
```

## Blue Screen Handler

Converts your exception reports into beautiful and clear html files using [Tracy](https://tracy.nette.org).

[![Uncaught exception rendered by Tracy](http://nette.github.io/tracy/images/tracy-exception.png)](http://nette.github.io/tracy/tracy-exception.html)

### Tell me how!

Just push the handler into the stack.

```php
use Nella\MonologTracy\BlueScreenHandler;
use Nella\MonologTracy\Tracy\BlueScreenFactory;
use Nella\MonologTracy\Tracy\LoggerHelper;

$logger = new Monolog\Logger('channel');

$factory = new BlueScreenFactory();
$helper = new LoggerHelper(__DIR__ . '/log', $factory->create());
$handler = new BlueScreenHandler($helper);

$logger->pushHandler($handler);
```

… Profit!

```php
$logger->critical('Exception occured!', array(
    'exception' => new Exception(),
));
```
