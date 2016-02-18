<?php
namespace Mpf\Application;

class Plugin
{
  protected $_registry;

  public function __construct($registry)
  {
    $this->_registry = $registry;
  }
}
