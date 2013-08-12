# BackgroundProcess

[![Build Status](https://travis-ci.org/kohkimakimoto/BackgroundProcess.png)](https://travis-ci.org/kohkimakimoto/BackgroundProcess)
[![Coverage Status](https://coveralls.io/repos/kohkimakimoto/BackgroundProcess/badge.png?branch=master)](https://coveralls.io/r/kohkimakimoto/BackgroundProcess?branch=master)

BackgroundProcess is a PHP Library to run background processes asynchronously on your system.

## Install


User composer installation with below `composer.json`.

``` json
{
  "require": {
    "kohkimakimoto/background-process": "dev-master"
  }
}
```

And run Composer install command.

```
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar install
```

## Usage

```php

use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

// Creates instance and set command string to run at the background.
$process = new BackgroundProcess("ls -l > /tmp/test.txt");
// Runs command. It returns immediately.
$process->run();

```

## TODO

Developing a command line tool to check the running process.


