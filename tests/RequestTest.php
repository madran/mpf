<?php
include __DIR__ . '/../src/Request.php';

use Mpf\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
  protected $_testData;

  public function setUp()
  {
    $this->_testData = ['key_1' => 'value_1'];
  }

  public function testSetGetValues()
  {
    $request = new Request();

    $request->setGetValues($this->_testData);
    $this->assertEquals(['key_1' => 'value_1'], $request->getGetValues());

    $request->setGetValues([]);
    $this->assertEquals(false, $request->getGetValues());
  }

  public function testSetGetValue()
  {
    $request = new Request();

    $request->setGetValue('key_1', 'value_1');
    $this->assertEquals('value_1', $request->getGetValue('key_1'));
  }

  public function testSetPostValues()
  {
    $request = new Request();

    $request->setPostValues($this->_testData);
    $this->assertEquals(['key_1' => 'value_1'], $request->getPostValues());
    $this->assertEquals('value_1', $request->getPostValue('key_1'));

    $request->setPostValues([]);
    $this->assertEquals(false, $request->getPostValues());
  }
}
