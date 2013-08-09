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
    public function __construct($commandline, $cwd = null, array $env = null, $stdin = null, $timeout = 60, array $options = array())
    {
        $this->process = new Process($commandline, $cwd, $env, $stdin, $timeout, $options);
    }

    /**
     * Run the process.
     */
    public function run()
    {
      // write process table json

      // execute background command.

      // execute proecss.

      // このクラス内では直接当該コマンドを実行しない。
      // バックグラウンドに移行するため、その前にコマンドを叩く。

    }
}
