<?php
include __DIR__ . '/../src/Db.php';
include __DIR__ . '/../src/Db/Adapter/MySQL.php';
include __DIR__ . '/../src/Db/Adapter/SQLite.php';
include __DIR__ . '/../src/Db/Adapter/PostgreSQL.php';
include __DIR__ . '/../src/Db/Model/Mapper.php';
include __DIR__ . '/../src/Db/Model/Table.php';

use Mpf\Db;

class DbTest extends PHPUnit_Framework_TestCase
{
  public function testReturnCorrectDriverClass()
  {
    $config['Db']['driver'] = 'MySQL';
    $config['Db']['username'] = 'root';
    $config['Db']['password'] = '1221';
    $config['Db']['host'] = 'localhost';
    $config['Db']['db_name'] = 'test';

    Db::setConfig($config);
    $db = new Db();
    $this->assertInstanceOf('Mpf\Db\Adapter\MySQL', $db->getAdapter());


    $config['Db']['driver'] = 'SQLite';

    Db::setConfig($config);
    $db = new Db();
    $this->assertInstanceOf('Mpf\Db\Adapter\SQLite', $db->getAdapter());


    $config['Db']['driver'] = 'PostgreSQL';

    Db::setConfig($config);
    $db = new Db();
    $this->assertInstanceOf('Mpf\Db\Adapter\PostgreSQL', $db->getAdapter());
  }

  public function testModel()
  {
    $config['Db']['driver'] = 'MySQL';
    $config['Db']['username'] = 'root';
    $config['Db']['password'] = '1221';
    $config['Db']['host'] = 'localhost';
    $config['Db']['db_name'] = 'test';

    Db::setConfig($config);
    $user = new UserMapper();
    $this->assertInstanceOf('Mpf\Db\Adapter\MySQL', $user->getTable()->getAdapter());
  }
}

class UserTable extends Mpf\Db\Model\Table
{

}

class UserMapper extends Mpf\Db\Model\Mapper
{
  protected $_tableModelName = 'UserTable';
}
