<?php
include __DIR__ . '/../src/Autoloader.php';

use Mpf\Autoloader;

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
  public function testPathSetupWithConfig()
  {
    $paths['Autoloader']['path'] = ['path_1/class_1', 'path_2/class_2'];
    $expectedPaths = ['vendor/mpf', 'application/controller', 'application/model', 'path_1/class_1', 'path_2/class_2'];

    $autoloader = new Autoloader($paths);

    $this->assertEquals($expectedPaths, PHPUnit_Framework_Assert::readAttribute($autoloader, '_autoloadDirectories'));
  }

  public function testPathSetupWithoutConfig()
  {
    $expectedPaths = ['vendor/mpf', 'application/controller', 'application/model'];

    $autoloader = new Autoloader();

    $this->assertEquals($expectedPaths, PHPUnit_Framework_Assert::readAttribute($autoloader, '_autoloadDirectories'));
  }

  public function testSetRootPath()
  {
    $config['Application']['root'] = '/home/lukasz/Projekty/php/projekt';

    $autoloader = new Autoloader($config);

    $this->assertEquals('/home/lukasz/Projekty/php/projekt', PHPUnit_Framework_Assert::readAttribute($autoloader, '_root'));

    $autoloader = new Autoloader();

    $this->assertEquals('/home/lukasz/Projekty/php/mpf/src/../..', PHPUnit_Framework_Assert::readAttribute($autoloader, '_root'));
  }
}
