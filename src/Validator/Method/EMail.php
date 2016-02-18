<?php
namespace Mpf\Validator\Method;

class EMail extends RegExp
{
  public function __construct($str)
  {
    $this->_str = $str;
    $this->_pattern = '/^[a-zA-z_]([a-zA-z_0-9-]*\.)*[a-zA-z_0-9-]+@([a-zA-Z0-9_]+\.)+([a-zA-Z]){2,3}$/';
  }

  public function getMessage()
  {
    return 'EMail';
  }
}
