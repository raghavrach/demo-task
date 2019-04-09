<?php
namespace App\Validators;

use App\Library\BaseValidator;

class UserValidator extends BaseValidator
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
        self::$key['name'] = 'Name';
        self::$key['email'] = 'Email';
    }
    
    public function setFormValidator($values)
    {
        // Name Field
        $nameKey = 'name';
        $nameLabel = self::$key[$nameKey];
        $this->_params[$nameKey] = $values[$nameKey];
        
        $this->_rules[$nameKey] = [
            $this->setNotBlankValidator($nameLabel)
        ];
        
        // Email Field
        $emailKey = 'email';
        $emailLabel = self::$key[$emailKey];
        $this->_params[$emailKey] = $values[$emailKey];
        
        $this->_rules[$emailKey] = [
            $this->setNotBlankValidator($emailLabel),
            $this->setEmailValidator(),
        ];
    }
}