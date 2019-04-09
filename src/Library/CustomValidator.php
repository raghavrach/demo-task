<?php
namespace App\Library;

use Symfony\Component\Validator\Validation;

/**
 * Custom validator to handle symfony validations.
 *
 */

class CustomValidator
{
  private $validators = null;
  private $violations = null;
  private $constraint = null;
  private $isSetRule = false;
  private $isBound = false;
  private $errors = null;

  public function __construct() {
    $this->init();
  }

  public function reset() {
    $this->init();
    return $this;
  }

  private function init() {
    $this->validators = Validation::createValidator();
    $this->violations = array();
    $this->constraint = array();
    $this->errors = array();
    $this->isSetRule = false;
    $this->isBound = false;
  }

  /**
   * @param $rule :: Hash
   *   Specify the item name to be verified and the mapping of verification logic.
   */
  public function setRule($rule) {
    $this->isSetRule = true;
    $this->constraint = $rule;
  }

  /**
   * Execution
   * @param $params :: Hash
   *   Combination of input value, Key and Value
   */
  public function bind($params) {
    if (!$this->isSetRule) {
      return false;
    }
    $this->isBound = true;
    foreach ($params as $key => $value) {
        if(isset($this->constraint[$key])) {
            $validate = false;
            foreach ($this->constraint[$key] as $constraint) {
                # If value is empty.
                if(empty($value)) {
                    # Validation will break if NotBlank and callback validateZero constraint are not set.
                    if(!$validate && !$constraint instanceof \Symfony\Component\Validator\Constraints\NotBlank)
                    {
                        break;
                    }
                }
                $results = $this->validators->validate($value, $constraint);
                if(isset($results[0])) {
                    $this->errors[$key] = $results[0];
                    break;
                }
            }
        }
    }
  }
  
  /**
   * Check for validation violations
   * 
   * @return boolean
   */
  public function isValid() {
    if (!$this->isSetRule || !$this->isBound)
    {
      return false;
    }
    return count($this->errors) === 0;
  }
  
  /**
   * Check if validation error exists
   * 
   * @return boolean
   */
  public function hasErrors() {
    if (!$this->isSetRule || !$this->isBound)
    {
      return false;
    }
    return count($this->errors) > 0;
  }

  /**
   * Determine if the specified item has an error
   * 
   * @param $name :: String
   * @return boolean In case of error: true
   */
  public function isInvalid($name) {
    return array_key_exists($name, $this->errors);
  }
  
  /**
   * Validation rules bound
   * 
   * @return boolean
   */
  private function isBound() {
    return $this->isBound;
  }

  /**
   * Return error information of the specified item
   * 
   * @param $name :: String
   * @return Array :: Error information array
   */
  public function getError($name) {
    if ( array_key_exists($name, $this->errors) ) {
      return $this->errors[$name];
    } else {
      return null;
    }
  }

  /**
    * Set error information of specified item
   * @param $name :: String
   * @return Array :: Error information array
   */
  public function setError($name , $validator) {
    $this->errors[$name] = $validator;
  }

  /**
   * Error information acquisition
   * @return Array :: Error information array
   */
  public function errors() {
    return $this->errors;
  }
}