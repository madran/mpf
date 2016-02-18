<?php
namespace Mpf\Application;

class Bootstrap
{
  protected $_registry;

  public function __construct($registry)
  {
    $this->_registry = $registry;
  }
}
