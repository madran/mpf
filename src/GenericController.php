<?php
namespace Mpf;

class GenericController
{

  protected $_registry;
  protected $_view;
  protected $_request;

  public function setRegistry($registry)
  {
    $this->_registry = $registry;
    $this->_view = $registry->getResource('view');
    $this->_request = $registry->getResource('request');
  }
}
