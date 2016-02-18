<?php
namespace Mpf\Db\Adapter;

use Exception;
use PDO;

class MySQL
{
  private $_driver;
  private $_host;
  private $_username;
  private $_password;
  private $_dbName;

  private $_handler;

  public function __construct($config)
  {
    if (is_array($config['Db'])) {
      $this->_driver = 'mysql';
      $this->_host = $config['Db']['host'];
      $this->_username = $config['Db']['username'];
      $this->_password = $config['Db']['password'];
      $this->_dbName = $config['Db']['db_name'];
    } else throw new Exception('Invalid db config provided.');

    $this->setDbHandler();
  }

  private function setDbHandler()
  {
    $dsn = $this->_driver . ':host=' . $this->_host . ';dbname=' . $this->_dbName . ';encoding=utf8';

    try {
      $this->_handler = new PDO($dsn, $this->_username, $this->_password);
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function getDbHandler()
  {
    return $this->_handler;
  }
}
