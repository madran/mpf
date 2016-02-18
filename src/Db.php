<?php
namespace Mpf;

use Exception;

class Db
{
  protected static $_config;
  protected $_adapter;

  // public function __construct(array $config)
  // {
  //   $this->_config = $config;
  // }

  public static function setConfig($config)
  {
    self::$_config = $config;
  }

  public function getConfig()
  {
    return self::$_config;
  }

  public function getAdapter()
  {
    $config = $this->getConfig();
    
    if (isset($this->_adapter)) {
      return $this->_adpater;
    } else {
      if (isset($config['Db']['driver'])) {
        $className = 'Mpf\Db\Adapter\\' . $config['Db']['driver'];
        $this->_adpater = new $className($config);
        return $this->_adpater;
      } else {
        throw new Exception('No Db driver provided.');
      }
    }
  }
}
