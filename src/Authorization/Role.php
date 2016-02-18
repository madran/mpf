<?php
namespace Mpf\Authorization;

class Role
{
  private $_name;
  private $_parents;
  private $_allowedResources;

  public function __construct($name)
  {
    $this->_name = $name;
  }

  public function addParents($parents)
  {
    $this->_parents = $parents;
  }

  public function getName()
  {
    return $this->_name;
  }

  public function addAllowRule(Resource $resource)
  {
    $this->_allowedResources[$resource->getController()][$resource->getAction()] = true;
  }

  public function getAllowRule($controller, $action)
  {
    if(isset($this->_allowedResources[$controller][$action])) return true;
    else false;
  }

  public function getParents()
  {
    return $this->_parents;
  }
}
