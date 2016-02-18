<?php
namespace Mpf;

use Exception;

class View
{

  private $_layout;
  private $_page;
  private $_var;
  private $_config;

  public function __construct(array $config)
  {
    $this->_config = $config;
  }

  public function setLayout($name)
  {
    $this->_layout = $name;
  }

  public function setPage($name)
  {
    $this->_page = $name;
  }

  public function render()
  {
    if (isset($this->_config['View']['layout'])) {
      $this->renderLayout();
    } else {
      $this->renderPage();
    }
  }

  private function renderLayout()
  {
    $layoutPath = $this->_config['Application']['root'] . '/application/view/layout/' . $this->_config['View']['layout']['default'];

    if (file_exists($layoutPath)) include($layoutPath);
    else throw new Exception('Layout do not exsist.');
  }

  private function renderPage()
  {
    $pagePath = $this->_config['Application']['root'] . '/application/view/' . $this->_page . '.php';

    if (file_exists($pagePath)) include($pagePath);
    else throw new Exception('View do not exsist.'.$pagePath);

  }

  public function __set($name, $value)
  {
    $this->_var[$name] = $value;
  }

  public function __get($name)
  {
    if(isset($this->_var[$name])) return $this->_var[$name];
    else return false;
  }
}
