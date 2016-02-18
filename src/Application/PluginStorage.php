<?php
namespace Mpf\Application;

class PluginStorage
{
  protected $_storage = [];

  public function addBeforeRoute(Plugin $plugin)
  {
    $this->_storage['before'][] = $plugin;
  }

  public function addBetweenRouteDispach(Plugin $plugin)
  {
    $this->_storage['between'][] = $plugin;
  }

  public function addAfterDispach(Plugin $plugin)
  {
    $this->_storage['after'][] = $plugin;
  }

  public function runBeforeRoute()
  {
    if (isset($this->_storage['before'])) {
      foreach ($this->_storage['before'] as $plugin) {
        $plugin->run();
      }
    }
  }

  public function runBetweenRouteDispach()
  {
    if (isset($this->_storage['between'])) {
      foreach ($this->_storage['between'] as $plugin) {
        $plugin->run();
      }
    }
  }

  public function runAfterDispach()
  {
    if (isset($this->_storage['after'])) {
      foreach ($this->_storage['after'] as $plugin) {
        $plugin->run();
      }
    }
  }
}
