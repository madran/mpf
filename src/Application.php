<?php
namespace Mpf;

use Exception;

class Application
{
  private $_registry;
  private $_config;

  private $_controller;
  private $_action;

  private $_isDispached;

  public function __construct(array $config = [])
  {
    Db::setConfig($config);
    $this->_registry = new Registry();
    $this->_registry->addResource('request', new Request());
    $this->_registry->addResource('view', new View($config));
    $this->_registry->addResource('session', new Session());
    $this->_registry->addResource('config', $config);
    $this->_registry->addResource('plugin_storage', new Application\PluginStorage());
    $this->_registry->addResource('application', $this);

    $this->_config = $config;
    $this->_isDispached = false;
  }

  public function run()
  {
    $request = $this->_registry->getResource('request');

    $request->setGetValues($_GET);
    $request->setPostValues($_POST);

    if (isset($this->_config['Application']['bootstrap']['path'])) {
      $bootstrapPath = $this->_config['Application']['bootstrap']['path'] . '/Bootstrap.php';
    } else {
      $bootstrapPath = $this->_config['Application']['root'] . '/application/Bootstrap.php';
    }
    if (file_exists($bootstrapPath)) {
      include $bootstrapPath;
    } else {
      throw new Exception('Bootstrap.php not exists.');
    }

    $bootstrap = new \Bootstrap($this->_registry);
    $classMethods = get_class_methods('Bootstrap');

    foreach ($classMethods as $method) {
      if (preg_match('/init/', $method)) {
        $bootstrap->$method();
      }
    }

    while (!$this->_isDispached) {
      $this->_isDispached = true;

      $this->_registry->getResource('plugin_storage')->runBeforeRoute();

      $this->route();

      $this->_registry->getResource('plugin_storage')->runBetweenRouteDispach();
      $this->_registry->getResource('view')->setPage($this->_controller . '/' . str_replace('Action', '', $this->_action));

      $this->dispatch();

      $this->_registry->getResource('plugin_storage')->runAfterDispach();
    }
  }

  private function route()
  {
    $request = $this->_registry->getResource('request');

    $controller = $request->getGetValue('controller');
    if ($controller == false) {
      if (isset($this->_config['Application']['default']['controller'])) {
        $this->_controller = $this->_config['Application']['default']['controller'] . 'Controller';
      } else {
        $this->_controller = 'DefaultController';
      }
    } else {
      $this->_controller = ucfirst($controller) . 'Controller';
    }

    $action = $request->getGetValue('action');
    if ($action == false) {
      if (isset($this->_config['Application']['default']['action'])) {
        $this->_action = $this->_config['Application']['default']['action'] . 'Action';
      } else {
        $this->_action = 'indexAction';
      }
    } else {
      $this->_action = $action . 'Action';
    }
  }

  private function dispatch()
  {
    if (!file_exists($this->_config['Application']['root'] . '/application/controller/' . $this->_controller . '.php')) {
      $this->_controller = 'ErrorController';
      $this->_action = 'error404Action';
    }

    if (!method_exists($this->_controller, $this->_action)) {
      $this->_controller = 'ErrorController';
      $this->_action = 'error404Action';
    }

    $controller = new $this->_controller();

    $controller->setRegistry($this->_registry);

    call_user_func(array(&$controller, $this->_action));
  }

  public function setNewRoute($controller, $action, $a = false)
  {
    $this->_isDispached = $a;
    $request = $this->_registry->getResource('request');
    $request->setGetValue('controller', $controller);
    $request->setGetValue('action', $action);
  }

  public function __destruct()
  {
    $this->_registry->getResource('view')->render();
  }

  public function setController($controller)
  {
    $this->_controller = $controller;
  }

  public function setAction($action)
  {
    $this->_action = $action;
  }
}
