<?php
namespace Mpf;

class Session
{

  public function __construct()
  {
    if($this->getSessionVar('our_sid')) session_destroy();

    session_start();
    session_regenerate_id();

    $this->setSessionVar('our_sid', true);
  }

  public function getSessionVar($name)
  {
    if(isset($_SESSION[$name])) return $_SESSION[$name];
    else false;
  }

  public function setSessionVar($name, $value)
  {
    $_SESSION[$name]= $value;
  }

  public function destroy()
  {
    unset($_SESSION);
    session_destroy();
  }
}
