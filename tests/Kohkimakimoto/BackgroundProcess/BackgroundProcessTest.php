<?php
namespace Test\Kohkimakimoto\BackgroundProcess;

use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

class BackgroundProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        if (file_exists("/tmp/BackgroundProcess_t1.sh.output")) {
          unlink("/tmp/BackgroundProcess_t1.sh.output");
        }

        $process = new BackgroundProcess("sh ".__DIR__."/BackgroundProcessTest/t1.sh");
        $process->run();

        sleep(4);

        if (!file_exists($process->getExecutablePHPFilePath())) {
          // File has not deleted. It's fail.
          $this->assertEquals(true, true);
        } else {
          $this->assertEquals(true, false);
        }

        $retVal = file_get_contents("/tmp/BackgroundProcess_t1.sh.output");
        $this->assertEquals("aaaa\naaaa\naaaa\n", $retVal);
    }


}