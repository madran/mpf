<?php
namespace Mpf\Validator\Filter;

class HTMLSpecialChars
{
  protected $_str;

  public function __construct($str)
  {
    $this->_str = $str;
  }

  public function filter()
  {
    return htmlspecialchars($this->_str, ENT_COMPAT | ENT_HTML5);
  }
}
