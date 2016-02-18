<?php
namespace Mpf\Db\Adapter;

use Exception;

class SQLite
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

  }

  public function getDbHandler()
  {
    return $this->_handler = false;
  }
}
