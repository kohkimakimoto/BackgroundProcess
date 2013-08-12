<?php
namespace Kohkimakimoto\BackgroundProcess;

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;


/**
 *
 * @author Kohki Makimoto
 */
class BackgroundProcess
{
    protected $process;

    protected $backendProcessKey;

    protected $workingDirectory;

    protected $jsonPath;


    /**
     * Constractor.
     *
     * @param unknown $commandline
     * @param string $cwd
     * @param array $env
     * @param string $stdin
     * @param number $timeout
     * @param array $options
     */
    // public function __construct($commandline, $cwd = null, array $env = null, $stdin = null, $timeout = 60, array $options = array())
    public function __construct($commandline)
    {
      // $this->process = new Process($commandline, $cwd, $env, $stdin, $timeout, $options);
      $this->commandline = $commandline;
      $this->workingDirectory = "/tmp/php/background_process";
    }

    /**
     * Run the process.
     */
    public function run()
    {
      $this->writeProcessJsonFile();
      $command = $this->getBackgroundProcessingRunCommand();
      $pid = exec($command);
      $this->appendPidToProcessJsonFile($pid);
    }

    public function writeProcessJsonFile()
    {
      $fs = new Filesystem();
      $dir = rtrim($this->getWorkingDirectory(), "/");
      $key = $this->getBackgroundProcessKey();

      if (!$fs->exists($dir)) {
        // create directory.
        $fs->mkdir($path, 0777);
      }

      $path = $dir."/process.".$key.".json";
      if ($fs->exists($path)) {
        throw new Exception("$path is already exists.");
      }

      $currentUmask = umask();
      umask(0000);

      if (!$fp = @fopen($path, 'wb')) {
        throw new sfCacheException(sprintf('Unable to write cache file "%s".', $tmpFile));
      }

      $contents =json_encode(array(
          "key" => "$key",
          "commandline" => $this->commandline,
          "pid" => null,
      ));

      @fwrite($fp, $contents);
      @fclose($fp);

      umask($currentUmask);

      $this->jsonPath = $path;
      return $this->jsonPath;
    }

    /**
     * Generate unique key for indentifing background process.
     */
    public function getBackgroundProcessKey()
    {
      if (!$this->backendProcessKey) {
        $this->backendProcessKey = uniqid(getmypid());
      }
      return $this->backendProcessKey;
    }

    public function getBackgroundProcessingRunCommand()
    {
      return sprintf('nohup %s > /dev/null 2>&1 < /dev/null & echo $!', $this->commandline);
    }

    public function getWorkingDirectory()
    {
      return $this->workingDirectory;
    }

    public function appendPidToProcessJsonFile($pid)
    {
      $path = $this->jsonPath;
      if (!$fp = @fopen($path, 'wb')) {
        throw new sfCacheException(sprintf('Unable to write cache file "%s".', $tmpFile));
      }

      $key = $this->getBackgroundProcessKey();

      $contents =json_encode(array(
          "key" => "$key",
          "commandline" => $this->commandline,
          "pid" => $pid,
      ));

      @fwrite($fp, $contents);
      @fclose($fp);
    }

}
