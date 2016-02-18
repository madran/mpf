<?php
namespace Mpf\Db\Model;

use Exception;
use PDO;

class Mapper
{
  protected $_tableModelName;
  protected $_tableName;
  protected $_table;

  public function setDbTable($tableModelName)
  {
    if (is_string($tableModelName)) {
      $this->_table = new $tableModelName();
    } else throw new Exception('Invalid table data gateway provided');
  }

  public function getTable()
  {
    if(!isset($this->_table)) $this->setDbTable($this->_tableModelName);
    return $this->_table;
  }

  public function getAll()
  {
    $table = $this->getTable()->getAdapter()->getDbHandler();
    $stmt = $table->prepare('SELECT * FROM ' . $this->_tableName);
    $stmt->execute();

    $stmtResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $resultSize = sizeof($stmtResult);
    $className = substr($this->_tableModelName, 0, -5);

    $result = [];
    if ($resultSize) {
      for ($i = 0; $i < $resultSize; $i++) {
        $result[$i] = new $className();
        foreach ($stmtResult[$i] as $key => $value) {
          $setter = explode('_', $key);
          for ($j = 0; $j < count($setter); $j++) $setter[$j] = ucfirst($setter[$j]);
          $setter = 'set' . implode($setter);
          $result[$i]->$setter($value);
        }
      }
    }

    return $result;
  }

  public function find($id)
  {
    $table = $this->getTable()->getAdapter()->getDbHandler();

    $stmt = $table->prepare('SELECT * FROM ' . $this->_tableName . ' WHERE id=:id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $stmtResult = $stmt->fetch(PDO::FETCH_ASSOC);
    $resultSize = sizeof($stmtResult);

    if (!empty($stmtResult)) {
      $className = substr($this->_tableModelName, 0, -5);
      $result = new $className();
      foreach ($stmtResult as $key => $value) {
        $setter = explode('_', $key);
        for ($i = 0; $i < count($setter); $i++) $setter[$i] = ucfirst($setter[$i]);
        $setter = 'set' . implode($setter);
        $result->$setter($value);
      }
    }

    return $result;
  }

  public function save($object)
  {
    $table = $this->getTable()->getAdapter()->getDbHandler();

    $methods = get_class_methods($object);
    $j = 0;
    for ($i = 0; $i < count($methods); $i++) {
      if (strstr($methods[$i], 'get')) {
        if (empty($object->$methods[$i]())) continue;
        preg_match_all('/[A-Z][a-z]+/', $methods[$i], $matches);
        $names[$j] = '';
        foreach ($matches[0] as $match) {
          $names[$j] = $names[$j] . lcfirst($match) . '_';
        }
        $names[$j] = substr($names[$j], 0, -1);
        $j++;
      }
    }

    $q = $w = '';
    $query = 'INSERT INTO ' . $this->_tableName;
    foreach ($names as $name) {
      $q = $q . $name . ',';
      $w = $w . ':' . $name . ',';
    }

    $q = substr($q, 0, -1);
    $w = substr($w, 0, -1);

    $query = $query . ' (' . $q . ') VALUES (' . $w . ')';
    $stmt = $table->prepare($query);
    $i = 0;
    foreach ($methods as $method) {
      if (strstr($method, 'get')) {
        if (empty($object->$method())) continue;
        $stmt->bindValue(':'.$names[$i], $object->$method(), PDO::PARAM_STR);
        $i++;
      }
    }

    $result = $stmt->execute();

    if(!$result) throw new Exception('Row save error.');

  }

  public function update($object)
  {
    $table = $this->getTable()->getAdapter()->getDbHandler();

    $methods = get_class_methods($object);
    $j = 0;
    for ($i = 0; $i < count($methods); $i++) {
      if (strstr($methods[$i], 'get')) {
        if (empty($object->$methods[$i]())) continue;
        preg_match_all('/[A-Z][a-z]+/', $methods[$i], $matches);
        $names[$j] = '';
        foreach ($matches[0] as $match) {
          $names[$j] = $names[$j] . lcfirst($match) . '_';
        }
        $names[$j] = substr($names[$j], 0, -1);
        $j++;
      }
    }

    $w = '';
    $query = 'UPDATE ' . $this->_tableName . ' SET ';
    foreach ($names as $name) {
      $w = $w . $name . '= :' . $name . ',';
    }
    $w = substr($w, 0, -1);
    $query = $query . $w . ' WHERE id=:id';

    $stmt = $table->prepare($query);

    $i = 0;
    foreach ($methods as $method) {
      if (strstr($method, 'get')) {
        if (empty($object->$method())) continue;
        echo ' '.$names[$i].' ';
        $stmt->bindValue(':'.$names[$i], $object->$method(), PDO::PARAM_STR);
        $i++;
      }
    }

    $result = $stmt->execute();

    if(!$result) throw new Exception('Row update error.');
  }

  public function delete($id)
  {
    $table = $this->getTable()->getAdapter()->getDbHandler();

    $stmt = $table->prepare('DELETE FROM ' . $this->_tableName . ' WHERE id = :id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
  }
}
