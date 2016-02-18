<?php
namespace Mpf\Validator\Method;

class StringLenght
{
  protected $_str;
  protected $_min = false;
  protected $_max = false;

  public function __construct($str, $options)
  {
    $this->_str = $str;

    if(isset($options['min'])) $this->_min = $options['min'];
    if(isset($options['max'])) $this->_max = $options['max'];
  }

  public function validate()
  {
    $strSize = strlen($this->_str);
    // echo $this->_str . "s\n";
    if ($this->_min && $this->_max) {
      return (($this->_min <= $strSize) && ($this->_max >= $strSize));
    } else {
      if ($this->_min) {
        return ($this->_min <= $strSize);
      } else {
        return ($this->_max >= $strSize);
      }
    }
  }

  public function getMessage()
  {
    return 'StringLenght';
  }
}
