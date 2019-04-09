<?php
namespace App\Library\Utils;

/**
 * Security utility functions
 *
 */
class SecurityUtil
{
    /**
     * Escape all the values(recursively)
     * 
     * @param  array  $message
     * @return string  $messageHtml
     */
    public static function getEncocedPassword($password)
    {
        return md5($password);
    }
}
