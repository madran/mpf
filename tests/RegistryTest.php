<?php
include __DIR__ . '/../src/Registry.php';

use Mpf\Registry;

class RegistryTest extends PHPUnit_Framework_TestCase
{
  public function testAddObject()
  {
    $obj = new stdClass();
    $registry = new Registry();

    $registry->addResource('obj', $obj);

    $this->assertEquals($obj, $registry->getResource('obj'));
  }
}
