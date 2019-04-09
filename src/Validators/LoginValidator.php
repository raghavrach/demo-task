<?php
namespace App\Validators;

use Symfony\Component\Validator\Constraints as Assert;
use App\Library\BaseValidator;
use App\Library\MessageConst;

class LoginValidator extends BaseValidator
{
    /**
     * Initialize required variables
     */
    protected static $key = array();

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Set label array
     *
     *@return None
     */
    protected function _makeKeyLabel()
    {
        self::$key['email'] = 'Email';
        self::$key['password'] = 'Password';
    }
    
    public function setFormValidator($values)
    {
        // Email Field
        $emailKey = 'email';
        $emailLabel = self::$key[$emailKey];
        $this->_params[$emailKey] = $values[$emailKey];
        
        $this->_rules[$emailKey] = [
            $this->setNotBlankValidator($emailLabel),
            $this->setEmailValidator(),
        ];
        
        // Password Field
        $passwordKey = 'password';
        $passwordLabel = self::$key[$passwordKey];
        $this->_params[$passwordKey] = $values[$passwordKey];
        $this->_rules[$passwordKey] = [ $this->setNotBlankValidator($passwordLabel) ];
    }
}