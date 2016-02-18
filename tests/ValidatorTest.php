<?php
include __DIR__ . '/../src/Validator.php';
include __DIR__ . '/../src/Validator/Method/StringLenght.php';
include __DIR__ . '/../src/Validator/Method/RegExp.php';
include __DIR__ . '/../src/Validator/Method/EMail.php';

use Mpf\Validator;

class ValidatorFilterTest extends PHPUnit_Framework_TestCase
{
  protected $_validator;

  public function setUp()
  {
    $this->_validator = new Validator();
  }

  public function testRequire()
  {
    $this->_validator->add(
        [
          'name' => 'test',
          'require' => true
        ]
    );

    $test['test'] = 'test';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = '';
    $this->assertEquals(false, $this->_validator->isValid($test));
  }

  public function testStringLenghtMin()
  {
    $this->_validator->add(
        [
          'name' => 'test',
          'validators' => ['StringLenght' => ['min' => 5]]
        ]
    );

    $test['test'] = '55555';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = '4444';
    $this->assertEquals(false, $this->_validator->isValid($test));
  }

  public function testStringLenghtMax()
  {
    $this->_validator->add(
        [
          'name' => 'test',
          'validators' => ['StringLenght' => ['max' => 5]]
        ]
    );

    $test['test'] = '55555';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = '666666';
    $this->assertEquals(false, $this->_validator->isValid($test));
  }

  public function testStringLenghtMinMax()
  {
    $this->_validator->add(
        [
          'name' => 'test',
          'validators' => ['StringLenght' => ['min' => 5, 'max' => 8]]
        ]
    );

    $test['test'] = '22';
    $this->assertEquals(false, $this->_validator->isValid($test));

    $test['test'] = '55555';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = '7777777';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = '88888888';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = '999999999';
    $this->assertEquals(false, $this->_validator->isValid($test));
  }

  public function testRegExp()
  {
    $this->_validator->add(
        [
          'name' => 'test',
          'validators' => ['RegExp' => '/asd/']
        ]
    );

    $test['test'] = 'fasvasasd';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = 'avreeva';
    $this->assertEquals(false, $this->_validator->isValid($test));
  }

  public function testEMail()
  {
    $this->_validator->add(
        [
          'name' => 'test',
          'validators' => ['EMail' => true]
        ]
    );

    $test['test'] = 'jakaka.asds@afd.dfd';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = 'sdf-asf_jakaka.asds@afd.rfg';
    $this->assertEquals(true, $this->_validator->isValid($test));

    $test['test'] = 'sdf-asf_jakaka.asds@afd.rfgsafd';
    $this->assertEquals(false, $this->_validator->isValid($test));

    $test['test'] = 'jakaka.asds@afd';
    $this->assertEquals(false, $this->_validator->isValid($test));

    $test['test'] = 'jakaka.asdsafd.dfd';
    $this->assertEquals(false, $this->_validator->isValid($test));

    $test['test'] = '@afd.dfd';
    $this->assertEquals(false, $this->_validator->isValid($test));
  }
}
