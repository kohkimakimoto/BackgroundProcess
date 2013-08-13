<?php
namespace Test\Kohkimakimoto\BackgroundProcess;

use Kohkimakimoto\BackgroundProcess\BackgroundProcess;
use Kohkimakimoto\BackgroundProcess\BackgroundProcessManager;

class BackgroundProcessManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
      if (file_exists("/tmp/BackgroundProcessManager_t1.sh.output")) {
        unlink("/tmp/BackgroundProcessManager_t1.sh.output");
      }

      $process = new BackgroundProcess("sh ".__DIR__."/BackgroundProcessManagerTest/t1.sh");
      $process->run();

      $key = $process->getKey();
      $dir = $process->getManager()->getWorkingDirectory();

      // wait for creating json file.
      while (!file_exists($dir."/".$key.".json")) { }

      $manager = new BackgroundProcessManager();
      $processList = $manager->processList();

      $this->assertEquals($key, $processList[0]->getKey());
    }

    public function testAccessor()
    {
      $manager = new BackgroundProcessManager();

      $manager->setWorkingDirectory("/var/tmp");
      $this->assertEquals("/var/tmp", $manager->getWorkingDirectory());

      $manager->setKeyPrefix("prefix111");
      $this->assertEquals("prefix111", $manager->getKeyPrefix());
    }

}