<?php
include __DIR__ . '/../src/Validator.php';
include __DIR__ . '/../src/Validator/Filter/StringTrim.php';
include __DIR__ . '/../src/Validator/Filter/StripTags.php';
include __DIR__ . '/../src/Validator/Filter/HTMLSpecialChars.php';

use Mpf\Validator;

class ValidatorFilterTest extends PHPUnit_Framework_TestCase
{
  public function testFilterStringTrim()
  {
    $validator = new Validator();

    $validator->add(
        [
          'name' => 'test1',
          'filters' => ['StringTrim']
        ]
    );
    $validator->add(
        [
          'name' => 'test2',
          'filters' => ['StringTrim']
        ]
    );
    $validator->add(
        [
          'name' => 'test3',
          'filters' => ['StringTrim']
        ]
    );

    $test['test1'] = 'test ';
    $test['test2'] = ' test ';
    $test['test3'] = ' test test ';

    $validator->isValid($test);

    $this->assertEquals('test', $validator->get('test1'));
    $this->assertEquals('test', $validator->get('test2'));
    $this->assertEquals('test test', $validator->get('test3'));
  }

  public function testFilterStripTags()
  {
    $validator = new Validator();
    $validator->add(
        [
          'name' => 'test1',
          'filters' => ['StripTags']
        ]
    );
    $validator->add(
        [
          'name' => 'test2',
          'filters' => ['StripTags']
        ]
    );

    $test['test1'] = '<p>test</p>';
    $test['test2'] = '<div><span>test</span><br></div>';

    $validator->isValid($test);

    $this->assertEquals('test', $validator->get('test1'));
    $this->assertEquals('test', $validator->get('test2'));
  }

  public function testHTMLSpecialChars()
  {
    $validator = new Validator();
    $validator->add(
        [
          'name' => 'test1',
          'filters' => ['HTMLSpecialChars']
        ]
    );

    $test['test1'] = '<test>';

    $validator->isValid($test);

    $this->assertEquals('&lt;test&gt;', $validator->get('test1'));
  }
}
