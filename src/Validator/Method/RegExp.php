<?php
namespace Mpf\Validator\Method;

class RegExp
{
  protected $_str;
  protected $_pattern;

  public function __construct($str, $pattern)
  {
    $this->_str = $str;
    $this->_pattern = $pattern;
  }

  public function validate()
  {
    return preg_match($this->_pattern, $this->_str);
  }

  public function getMessage()
  {
    return 'RegExp';
  }
}
