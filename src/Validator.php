<?php
namespace Mpf;

class Validator
{

  private $_params;
  private $_results;
  private $_values;

  public function add(array $param)
  {
    $this->_params[$param['name']] = $param;
  }

  // private function isDate($name, $value, $methodValue, $message)
  // {
  //   if (preg_match('/^(19|20)[0-9][0-9]-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/', $value) == 1) {
  //     $this->_errors[$name]['isDate'] = false;
  //   } else {
  //     if($message) $this->_errors[$name]['isDate'] = $message;
  //     else $this->_errors[$name]['isDate'] = 'To nie jest poprawna data.';
  //     $this->_errorExsist = true;
  //   }
  // }

  public function get($key)
  {
    return $this->_values[$key];
  }

  public function isValid($values)
  {
    $this->_results = [];
    $this->_values = $values;
    foreach ($this->_params as $paramName => $paramOptions) {
      if(!isset($this->_values[$paramName])) continue;
      if (isset($paramOptions['require']) && $paramOptions['require'] == true) {
        if(empty($this->_values[$paramName])) $this->_results['require'] = 'require';
      }
      if (isset($paramOptions['filters'])) {
        foreach ($paramOptions['filters'] as $filterName) {
          $filter = 'Mpf\Validator\Filter\\' . $filterName;
          $this->_values[$paramName] = (new $filter($this->_values[$paramName]))->filter();
        }
      }
      if (isset($paramOptions['validators'])) {
        foreach ($paramOptions['validators'] as $validatorName => $options) {
          $validator = 'Mpf\Validator\Method\\' . $validatorName;
          $validator = new $validator($this->_values[$paramName], $options);
          if (!$validator->validate()) {
            $this->_results[$paramName][$validatorName] = $validator->getMessage();
          }
        }
      }
    }

    if(!empty($this->_results)) return false;
    else return true;
  }

  public function getResult($param)
  {
    return $this->_results[$param];
  }

  public function getAllResults()
  {
    return $this->_results;
  }
}
