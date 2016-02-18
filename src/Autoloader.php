<?php
namespace Mpf;

use Exception;

class Autoloader
{
  protected $_root = '';
  protected $_config = false;
  protected $_autoloadDirectories = [];

  public function __construct(array $config = [])
  {
    if (isset($config['Application']['root'])) {
      $this->_root = $config['Application']['root'];
    } else {
      throw new Exception('Appliction path root is not provided.');
    }

    $this->_autoloadDirectories[] = 'vendor';
    $this->_autoloadDirectories[] = 'application/controller';
    $this->_autoloadDirectories[] = 'application/model';
    if (isset($config['Autoloader']['path'])) {
      $size= count($config['Autoloader']['path']);
      for ($i = 0; $i < $size; $i++) {
        $this->_autoloadDirectories[] = $config['Autoloader']['path'][$i];
      }
    }

    spl_autoload_register(array($this, 'autoload'));
  }

  public function autoload($className)
  {
    $size = count($this->_autoloadDirectories);
    for ($i = 0; $i < $size; $i++) {
      $path = $this->_root . '/' . $this->_autoloadDirectories[$i] . '/' . str_replace('\\', '/', $className) . '.php';
      if (file_exists($path)) {
        require_once $path;
      }
    }
  }
}
