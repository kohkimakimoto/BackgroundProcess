<?php
namespace Test\Kohkimakimoto\BackgroundProcess;

use Kohkimakimoto\BackgroundProcess\BackgroundProcess;

class BackgroundProcessTest extends \PHPUnit_Framework_TestCase
{
  public function testDefault()
  {
    $bgProcess = new BackgroundProcess("ls -l");
  }
}