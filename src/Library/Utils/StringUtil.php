<?php
namespace App\Library\Utils;

/**
 * String modifying utility functions
 *
 */
class StringUtil
{
    /**
     * Escape all the values(recursively)
     * 
     * @param  string  $value: Unescaped value
     * @return string  $value: Escaped value
     */
    public static function escape($value)
    {
        // no escape(null, numeric, boolean)
        if (!is_string($value)) {

            return $value;
        }

        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', true);
    }
}
