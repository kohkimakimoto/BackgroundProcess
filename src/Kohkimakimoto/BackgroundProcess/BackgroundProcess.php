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
      $this->commandline = $commandline;
      // $this->process = new Process($commandline, $cwd, $env, $stdin, $timeout, $options);

      $this->workingDirectory = "/tmp/php/background_process";

    }

    /**
     * Run the process.
     */
    public function run()
    {
      // write process table json
      // exec('nohup ');
    }

    public function writeCommandScript()
    {

      $fs = new Filesystem();
      $path = $this->getBackgroundProcessWoringDirectory();
      if ($fs->exists($path)) {
        throw new Exception("$path is already exists.");
      }

      $currentUmask = umask();
      umask(0000);

      // create directory.
      $fs->mkdir($path, 0777);

      if (!$fp = @fopen($path."/process.json", 'wb')) {
        throw new sfCacheException(sprintf('Unable to write cache file "%s".', $tmpFile));
      }

      $key = $this->getBackgroundProcessKey();
      $contents    = <<<EOF
{
  "key": "$key"
}

EOF;

      @fwrite($fp, $contents);
      @fclose($fp);

      umask($currentUmask);

    }

    public function getBackgroundProcessWoringDirectory()
    {
      $dir = rtrim($this->getWorkingDirectory(), '/');
      return $dir.'/'.$this->getBackgroundProcessKey();
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

    public function getBackgroundProcessingCommandline()
    {
      return sprintf('nohup %s &', $this->commandline);
    }

    public function getWorkingDirectory()
    {
      return $this->workingDirectory;
    }
}
