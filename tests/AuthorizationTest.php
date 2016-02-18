<?php
include __DIR__ . '/../src/Authorization.php';
include __DIR__ . '/../src/Authorization/Role.php';
include __DIR__ . '/../src/Authorization/Resource.php';

use Mpf\Authorization;
use Mpf\Authorization\Role;
use Mpf\Authorization\Resource;

class AuthorizationTest extends PHPUnit_Framework_TestCase
{
  public function testAuthorization()
  {
    $auth = new Authorization();

    $auth->addRole(new Role('guest'));
    $auth->addRole(new Role('cat'));
    $auth->addRole(new Role('dog'), array('cat', 'guest'));
    $auth->addRole(new Role('user'), array('guest'));
    $auth->addRole(new Role('admin'), array('user'));

    $auth->addResource(new Resource('user', 'index'));
    $auth->addResource(new Resource('user', 'add'));
    $auth->addResource(new Resource('user', 'remove'));
    $auth->addResource(new Resource('user', 'show'));
    $auth->addResource(new Resource('user', 'login'));
    $auth->addResource(new Resource('user', 'logout'));
    $auth->addResource(new Resource('notice', 'index'));

    $auth->allow('guest', 'user', 'login');
    $auth->allow('guest', 'user', 'add');

    $auth->allow('cat', 'notice', 'index');

    $auth->allow('user', 'user', 'logout');

    $auth->allow('admin', 'user', 'show');
    $auth->allow('admin', 'user', 'remove');

    $this->assertTrue($auth->isAllowed('guest', 'user', 'login'));
    $this->assertTrue($auth->isAllowed('guest', 'user', 'add'));

    $this->assertTrue($auth->isAllowed('user', 'user', 'add')); //
    $this->assertTrue($auth->isAllowed('user', 'user', 'logout'));

    $this->assertTrue($auth->isAllowed('admin', 'user', 'add')); //
    $this->assertTrue($auth->isAllowed('admin', 'user', 'logout')); //
    $this->assertTrue($auth->isAllowed('admin', 'user', 'show'));
    $this->assertTrue($auth->isAllowed('admin', 'user', 'remove'));

    $this->assertFalse($auth->isAllowed('user', 'user', 'remove'));
    $this->assertFalse($auth->isAllowed('guest', 'user', 'remove'));
    $this->assertFalse($auth->isAllowed('guest', 'user', 'logout'));

    $this->assertTrue($auth->isAllowed('cat', 'notice', 'index'));
    $this->assertTrue($auth->isAllowed('dog', 'notice', 'index'));
    $this->assertTrue($auth->isAllowed('dog', 'user', 'login'));
  }
}
