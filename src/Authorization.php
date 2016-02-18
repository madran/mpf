<?php
namespace Mpf;

use Mpf\Authorization\Role;
use Mpf\Authorization\Resource;

class Authorization
{

  private $_resources;
  private $_roles;
  private $_access;

  public function addRole(Role $role, array $parents = array())
  {
    if(!empty($parents)) $role->addParents($parents);
    $this->_roles[$role->getName()] = $role;
  }

  public function addResource(Resource $resource)
  {
    $this->resources[$resource->getController()][$resource->getAction()] = $resource;
  }

  public function allow($role, $controller, $action)
  {
    $this->_roles[$role]->addAllowRule($this->resources[$controller][$action]);
  }

  public function isAllowed($role, $controller, $action)
  {
    $role = $this->_roles[$role];
    $isAllowed = $role->getAllowRule($controller, $action);

    if($isAllowed) return true;

    $parents = $role->getParents();

    if (!empty($parents)) {
      foreach ($parents as $parent) {
        if($this->isAllowed($parent, $controller, $action)) return true;
      }
    }

    return false;
  }
}
