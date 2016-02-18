<?php
namespace Mpf\Authorization;

class Resource
{
  private $_controller;
  private $_action;

  public function __construct($controller, $action)
  {
    $this->_controller = $controller;
    $this->_action = $action;
  }

  public function getController()
  {
    return $this->_controller;
  }

  public function getAction()
  {
    return $this->_action;
  }
}
