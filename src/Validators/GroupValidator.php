<?php
namespace App\Validators;

use App\Library\BaseValidator;

class GroupValidator extends BaseValidator
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
    }
}