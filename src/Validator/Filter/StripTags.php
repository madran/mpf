<?php
namespace Mpf\Validator\Filter;

class StripTags
{
  protected $_str;

  public function __construct($str)
  {
    $this->_str = $str;
  }

  public function filter()
  {
    return strip_tags($this->_str);
  }
}
