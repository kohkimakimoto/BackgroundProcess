<?php
namespace Test\Kohkimakimoto\BackgroundProcess;

use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

class BackgroundProcessTest extends \PHPUnit_Framework_TestCase
{
    public function testRun()
    {
        $process = new BackgroundProcess("sh ".__DIR__."/BackgroundProcessTest/t1.sh");
        $process->run();
    }

}