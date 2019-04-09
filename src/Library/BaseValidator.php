<?php
namespace App\Library;

use Symfony\Component\Validator\Constraints as Assert;
use App\Library\MessageConst;

class BaseValidator
{
    /**
     * Contains the validator class.
     */
    protected $_validator = null;

    /**
     * Stores parameters。
     */
    protected $_params = array();

    /**
     * Stores the rules
     */
    protected $_rules = array();

    /**
     * Stores the check result.
     */
    protected $_isValid = null;

    /**
     * Stores screen errors
     */
    protected $_pageErrorList = array();

    /**
     * Symfony validation error code and corresponding sring.
     */
    public static $errorCodeList = array(
        Assert\NotBlank::IS_BLANK_ERROR => 'required',
        Assert\Length::TOO_LONG_ERROR => 'max_length',
        Assert\Regex::REGEX_FAILED_ERROR => 'invalid',
        Assert\Choice::TOO_MANY_ERROR => 'max',
        Assert\Choice::NO_SUCH_CHOICE_ERROR => 'choice'
    );

    /**
     * Construction
     */
    public function __construct()
    {
        $this->_validator = new CustomValidator();
        $this->_makeKeyLabel();
    }

    /**
     * Perform validation
     *
     * @return none
     */
    private function _doValidate()
    {
        // Rule setting
        $this->_validator->setRule($this->_rules);

        // Execution of validation, judgment
        $this->_validator->bind($this->_params);
        $this->_isValid = $this->_validator->isValid();
    }

    /**
        * Get check result
     *
     * @param  $displayMessage :: true if wish to recieve errors as strings, false for object 
     * @return $this->_isValid
     */
    public function isValid($displayMessage = true)
    {
        if (is_null($this->_isValid))
        {
            $this->_doValidate();
            $errors = $this->_validator->errors();
            // Diff the log error and the error displayed on the screen.
            foreach ($errors as $name => $error)
            {
                // Message type is to notify the user
                $errorCode = $error->getCode();
                $errorCode = (isset(self::$errorCodeList[$errorCode])) ? self::$errorCodeList[$errorCode] : $errorCode;
                $this->_pageErrorList[$name] = ($displayMessage)?$error->getMessage():$error;
            }
        }
        return $this->_isValid;
    }

    /**
     * Get an ARRAY of screen error messages
     *
     * @return $this->_pageErrorList
     */
    public function getPageErrors()
    {
        return $this->_pageErrorList;
    }

    /**
     * Error information acquisition
     * 
     * @return Array :: Error information array
     */
    public function errors() {
        return $this->_validator->errors();
    }
    
    /**
     * Setting not blank rule
     * 
     * @param $label String :: field label
     * @return Array :: Rule array
     */
    public function setNotBlankValidator($label)
    {
        return new Assert\NotBlank([
            'message'=> sprintf(MessageConst::VAL000001, $label)
        ]);
    }
    
    /**
     * Setting input type text strict validations
     * 
     * @param $label String :: field label
     * @return Array :: Rule array
     */
    public function setInputStrictValidator()
    {
        
    }
    
    /**
     * Setting email validation rule
     * 
     * @param $checkMX Boolean :: true or false
     * @return Array :: Rule array
     */
    public function setEmailValidator($checkMX = false)
    {
       return  new Assert\Email([
            'message' => MessageConst::VAL000003,
            'checkMX' => $checkMX,
        ]);
    }
}
