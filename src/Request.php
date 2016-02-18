<?php
namespace Mpf;

class Request
{
  private $_getValues;
  private $_postValues;

  public function setGetValues(array $get)
  {
    if(empty($get))
      $this->_getValues = false;
    else $this->_getValues = $get;
  }

  public function getGetValues()
  {
    if(isset($this->_getValues))
      return $this->_getValues;
    else false;
  }

  public function setGetValue($key, $value)
  {
    $this->_getValues[$key] = $value;
  }

  public function getGetValue($value)
  {
    if(isset($this->_getValues[$value]))
      return $this->_getValues[$value];
    else false;
  }

  public function setPostValues(array $post)
  {
    if(empty($post))
      $this->_postValues = false;
    else $this->_postValues = $post;
  }

  public function getPostValues()
  {
    if(isset($this->_postValues))
      return $this->_postValues;
    else false;
  }

  public function getPostValue($value)
  {
    if(isset($this->_postValues[$value]))
      return $this->_postValues[$value];
    else false;
  }

  public function isPost()
  {
    return (boolean)count($_POST);
  }
}
