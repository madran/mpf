<?php
namespace Mpf\Validator\Filter;

class StringTrim
{
  protected $_str;

  public function __construct($str)
  {
    $this->_str = $str;
  }

  public function filter()
  {
    return trim($this->_str);
  }
}
