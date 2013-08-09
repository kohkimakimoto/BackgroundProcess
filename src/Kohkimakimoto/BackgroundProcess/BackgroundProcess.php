<?php
namespace Kohkimakimoto\BackgroundProcess;

use Symfony\Component\Process\Process;

/**
 *
 * @author Kohki Makimoto
 */
class BackgroundProcess
{
  protected $process;

  public function __construct($commandline, $cwd = null, array $env = null, $stdin = null, $timeout = 60, array $options = array())
  {
    $this->process = new Process($commandline, $cwd, $env, $stdin, $timeout, $options);
  }
}
