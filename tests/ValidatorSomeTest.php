<?php
include __DIR__ . '/../src/Validator.php';
include __DIR__ . '/../src/Validator/Method/StringLenght.php';
include __DIR__ . '/../src/Validator/Method/RegExp.php';
include __DIR__ . '/../src/Validator/Method/EMail.php';
include __DIR__ . '/../src/Validator/Filter/StringTrim.php';
include __DIR__ . '/../src/Validator/Filter/StripTags.php';

use Mpf\Validator;

class ValidatorSomeTest extends PHPUnit_Framework_TestCase
{
  protected $_validator;

  public function setUp()
  {
    $this->_validator = new Validator();
  }

  public function testManyValues()
  {
    $this->_validator->add(
        [
          'name' => 'test1',
          'require' => true,
          'filters' => ['StringTrim', 'StripTags'],
          'validators' => [
                            'StringLenght' => ['min' => 5],
                            'RegExp' => '/asd/'
                          ]
        ]
    );
    $this->_validator->add(
        [
          'name' => 'test2',
          'require' => true,
          'filters' => ['StripTags', 'StringTrim'],
          'validators' => [
                            'StringLenght' => ['max' => 5],
                            'RegExp' => '/asd/'
                          ]
        ]
    );

    $test['test1'] = ' <p>wwasd</p>';
    $test['test2'] = 'asdw    ';

    $this->assertEquals(true, $this->_validator->isValid($test));
  }

  public function testSkipNotProvidedValues()
  {
    $this->_validator->add(
        [
          'name' => 'test1',
          'require' => true,
          'filters' => ['StringTrim', 'StripTags'],
          'validators' => [
                            'StringLenght' => ['min' => 5],
                            'RegExp' => '/asd/'
                          ]
        ]
    );
    $this->_validator->add(
        [
          'name' => 'test2',
          'require' => true,
          'filters' => ['StripTags', 'StringTrim'],
          'validators' => [
                            'StringLenght' => ['max' => 5],
                            'RegExp' => '/asd/'
                          ]
        ]
    );

    $test['test1'] = ' <p>wwasd</p>';

    $this->assertEquals(true, $this->_validator->isValid($test));
    $this->assertEquals('wwasd', $this->_validator->get('test1'));
  }
}
