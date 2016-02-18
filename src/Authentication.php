<?php
namespace Mpf;

use Exception;
use PDO;

class Authentication
{
  private $_tableName;
  private $_identityColumn;
  private $_credentialColumn;

  private $_identity;
  private $_credential;
  private $_hashMethod;

  private $_db;
  private $_session;

  public function __construct($db, array $config = [])
  {
    $this->_db = $db;

    if (isset($config['Authentication']['hashMethod'])) {
      $className = 'Mpf\Authentication\HashMethod\\' . $config['Authentication']['hashMethod'];
      $this->_hashMethod = new $className();
    } else {
      $this->_hashMethod = new Authentication\HashMethod\PlainCompare();
    }
    $this->_tableName = (isset($config['Authentication']['tableName'])) ? $config['Authentication']['tableName'] : 'user';
    $this->_identityColumn = (isset($config['Authentication']['identityColumn'])) ? $config['Authentication']['identityColumn'] : 'username';
    $this->_credentialColumn = (isset($config['Authentication']['credentialColumn'])) ? $config['Authentication']['credentialColumn'] : 'password';
  }

  public function setIdentity($identity)
  {
    $this->_identity = $identity;
  }

  public function setCredential($credential)
  {
    $this->_credential = $credential;
  }

  public function authenticate()
  {
    if (!isset($this->_identity) || !isset($this->_credential)) {
      throw new Exception('Not delivered identity or credential.');
    }

    $stmt = $this->_db->prepare('SELECT * FROM ' . $this->_tableName . ' WHERE ' . $this->_identityColumn . '="' . $this->_identity . '"');
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($this->_hashMethod->identityCompare($this->_identity, $user[$this->_identityColumn]) &&
        $this->_hashMethod->credentialCompare($this->_credential, $user[$this->_credentialColumn])) {
      return $user;
    } else {
      return false;
    }
  }
}
