<?php
include __DIR__ . '/../src/Authentication.php';
include __DIR__ . '/../src/Authentication/HashMethod/PlainCompare.php';

use Mpf\Authentication;
// use Mpf\Authentication\Authentication\HashMethods\PlainCompare;

class AuthenticationTest extends PHPUnit_Framework_TestCase
{
  protected $_stmt;
  protected $_db;

  protected function setUp()
  {
    $this->_stmt = $this->getMock('TestStatement');
    $this->_stmt->method('execute');
    $this->_stmt->method('fetchAll')->willReturn(['username' => 'admin', 'password' => '123']);

    $this->_db = $this->getMock('TestDB');
    $this->_db->method('prepare')->willReturn($this->_stmt);
  }

  public function testDefaultAuthentication()
  {
    $authentication = new Authentication($this->_db);
    $authentication->setIdentity('admin');
    $authentication->setCredential('123');


    $this->assertTrue(is_array($authentication->authenticate()));
  }

  public function testDefaultAuthenticationWithWrongIdentity()
  {
    $authentication = new Authentication($this->_db);
    $authentication->setIdentity('admin1');
    $authentication->setCredential('123');


    $this->assertFalse($authentication->authenticate());
  }

  public function testDefaultAuthenticationWithWrongCredential()
  {
    $authentication = new Authentication($this->_db);
    $authentication->setIdentity('admin');
    $authentication->setCredential('1234');


    $this->assertFalse($authentication->authenticate());
  }

  public function testDefaultAuthenticationWithConfig()
  {
    $config['Authentication']['hashMethod'] = 'PlainCompare';
    $config['Authentication']['tableName'] = 'usr';
    $config['Authentication']['identityColumn'] = 'usrname';
    $config['Authentication']['credentialColumn'] = 'pass';

    $this->_stmt = $this->getMock('TestStatement');
    $this->_stmt->method('execute');
    $this->_stmt->method('fetchAll')->willReturn(['usrname' => 'admin', 'pass' => '123']);

    $this->_db = $this->getMock('TestDB');
    $this->_db->method('prepare')->willReturn($this->_stmt);

    $authentication = new Authentication($this->_db, $config);
    $authentication->setIdentity('admin');
    $authentication->setCredential('123');


    $this->assertTrue(is_array($authentication->authenticate()));
  }
}

class TestDB
{
  public function prepare()
  {

  }
}

class TestStatement
{
  public function execute()
  {

  }

  public function fetchAll()
  {

  }
}
