<?php
namespace Test\Kohkimakimoto\BackgroundProcess;

use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

class BackgroundProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        // $process = new BackgroundProcess("ls -l");
        // $process->run();
    }

    public function testGetBackgroundProcessingCommandline()
    {
        $process = new BackgroundProcess("ls -la");
        $this->assertEquals("nohup ls -la &", $process->getBackgroundProcessingCommandline());
    }

    public function testWriteCommandScript()
    {
      $process = new BackgroundProcess("ls -la");
      $process->writeCommandScript();

    }

    public function testHetBackgroundProcessWoringDirectory()
    {
      $process = new BackgroundProcess("ls -la");
      $process->getBackgroundProcessWoringDirectory();
    }

}