<?php
namespace Mpf\Authentication\HashMethod;

class PlainCompare
{
  public function identityCompare($provided, $expected)
  {
    return ($provided == $expected);
  }

  public function credentialCompare($provided, $expected)
  {
    return ($provided == $expected);
  }
}
