<?php
namespace Kohkimakimoto\BackgroundProcess;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * BackgroundProcess
 * @author Kohki Makimoto <kohki.makimoto@gmail.com>
 */
class BackgroundProcessManager
{
  protected $options;
  protected $keyPrefix;
  protected $workingDirectory;

  const DEFAULT_KEY_PREFIX        = 'process.';
  const DEFAULT_WORKING_DIRECTORY = '/tmp/php/background_process';

  /**
   * Constractor.
   *
   * @param array $options Options to set environment.
   */
  public function __construct($options = array())
  {
    $this->options = $options;

    // Set up key prefix
    if (isset($options['key_prefix'])) {
      $this->keyPrefix = $options['key_prefix'];
    } else {
      // default value
      $this->keyPrefix = BackgroundProcessManager::DEFAULT_KEY_PREFIX;
    }

    // Set up workingDirectory
    if (isset($options['working_directory'])) {
      $this->workingDirectory = $options['working_directory'];
    } else {
      // default value
      $this->workingDirectory = BackgroundProcessManager::DEFAULT_WORKING_DIRECTORY;
    }

  }

  /**
   * list background processes.
   */
  public function listProcesses()
  {
    $finder = new Finder();
    $finder->files()->in($this->getWorkingDirectory())->name($this->getKeyPrefix()."*.json");

    $processes = array();
    foreach ($finder as $file) {
      $processes[] = $this->createBackgroundProcessFromJson($file->getContents());
    }

    return $processes;
  }

  /**
   * Load background process.
   * @param string $key
   * @return multitype:NULL
   */
  public function loadProcess($key)
  {
    $finder = new Finder();
    $finder->files()->in($this->getWorkingDirectory())->name($key.".json");

    foreach ($finder as $file) {
      return $this->createBackgroundProcessFromJson($file->getContents());
    }

    return null;
  }

  /**
   * Create new BackgroundProcess from Json string.
   * @param unknown $meta
   * @return \Kohkimakimoto\BackgroundProcess\BackgroundProcess
   */
  protected function createBackgroundProcessFromJson($json)
  {
    $meta = json_decode($json, true);

    $backgroudProcess = new BackgroundProcess($meta['commandline'], $this, $meta);
    return $backgroudProcess;
  }

  /**
   * Set working directory.
   * @param unknown $workingDirectory
   */
  public function setWorkingDirectory($workingDirectory)
  {
    $this->workingDirectory = $workingDirectory;
  }

  /**
   * Get working directory.
   */
  public function getWorkingDirectory()
  {
    return $this->workingDirectory;
  }

  /**
   * Set key prefix
   * @param unknown $filePrefix
   */
  public function setKeyPrefix($keyPrefix)
  {
    $this->keyPrefix = $keyPrefix;
  }

  /**
   * Get key prefix
   */
  public function getKeyPrefix()
  {
    return $this->keyPrefix;
  }

}

