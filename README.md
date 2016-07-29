# BackgroundProcess

[![Build Status](https://travis-ci.org/kohkimakimoto/BackgroundProcess.png)](https://travis-ci.org/kohkimakimoto/BackgroundProcess)
[![Coverage Status](https://coveralls.io/repos/kohkimakimoto/BackgroundProcess/badge.png?branch=master)](https://coveralls.io/r/kohkimakimoto/BackgroundProcess?branch=master)

BackgroundProcess is a PHP Library to run background processes asynchronously on your system.

## How it works

<a href="http://f.hatena.ne.jp/kohkimakimoto/20130812192611"><img src="http://img.f.hatena.ne.jp/images/fotolife/k/kohkimakimoto/20130812/20130812192611.png" alt="20130812192611"></a>

BackgroundProcess is simple. So it doesn't need any specific datastores such as RDBMS.
And dosen't use somthing like a queue and daemon process.

When BackgroundProcess runs a process on the background, It creates two special files.
One of them is an **Executable PHP file**. Another one is a **JSON meta data file**.

**Executable PHP file** is a PHP file executed by BackgroundProcess.
It includes the command to run specified by you.
It also has some initialization and finalization code.
At default, this file name is like the following.
```
/tmp/php/background_process/process.2494951fd9d147bc3e.php
```

**JSON meta data file** is a json formmated file. it's created at the preprocess in the **Executable PHP file**.
It includes process id and created timestamp.
It is used to inspect background process statuses through BackgroundProcessManager Class API.
At default, this file name is like the following
```
/tmp/php/background_process/process.2494951fd9d147bc3e.json
```
The executable PHP file and JSON meta data file have same name without extentions.

These two files are automatically deleted at the end of the processing.
Therefore, you generally don't need to manipulate them.

## Installation


User composer installation with below `composer.json`.

``` json
{
  "require": {
    "kohkimakimoto/background-process": "1.1.*"
  }
}
```

And runs Composer install command.

```
$ curl -s http://getcomposer.org/installer | php
$ php composer.phar install
```

## Usage

The following code runs a command on the background.

```php
use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

// Creates instance and set command string to run at the background.
$process = new BackgroundProcess("ls -l > /tmp/test.txt");
// Runs command, and it returns immediately.
$process->run();

// Get key identified the process.
$key = $process->getKey();
```

The following code inspects the background process.

```php
use Kohkimakimoto\BackgroundProcess\BackgroundProcessManager;

$manager = new BackgroundProcessManager();
$process = $manager->loadProcess($key);

// If a process specified by the key dosen't exist, loadProcess method returns null.
if (!$process) {
  echo "Not working process $key";
} else {
  $meta = $process->getMeta();
  echo $meta['created_at'];   // (ex 2013-01-01 10:00:20
  echo $meta['pid'];          // (ex 1234
}

```

If your command raises error, BackgroundProcess writes logs to error log file.
```
/tmp/php/background_process/err.log
```

## Configuration Options

You can use configuration options to change behavior of BackgroundProcess.

```php
use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

// Creates instance and set command string to run at the background.
$process = new BackgroundProcess("ls -l > /tmp/test.txt", array(
  'working_directory' => '/path/to/background_process_directroy',
  'key_prefix'        => 'prefix_of_key.',
  'error_log'         => 'your_error.log',
));
```

## License

Apache License 2.0









