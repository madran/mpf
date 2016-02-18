<?php
namespace Mpf\Db\Model;

class Table extends \Mpf\Db
{
  protected $_name;

  public function getTableName()
  {
    return $_name;
  }
}
