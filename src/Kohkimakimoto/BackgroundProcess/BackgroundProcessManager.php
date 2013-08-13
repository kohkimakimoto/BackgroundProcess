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
  public function processList()
  {
    $finder = new Finder();
    $finder->files()->in(__DIR__);
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

