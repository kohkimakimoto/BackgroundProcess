<?php
namespace Test\Kohkimakimoto\BackgroundProcess;

use Kohkimakimoto\BackgroundProcess\Cli;

class CliTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
      $cli = new Cli();
      $cli->execute();
    }

}