<?php
namespace App\Library\Utils;

/**
 * Message util functions
 *
 */
class MessageUtil
{
    /**
     * Escape all the values(recursively)
     * 
     * @param  array  $message
     * @return string  $messageHtml
     */
    public static function showMessages($message, $type = 'info', $escape = true)
    {
        if(!is_array($message) || sizeof($message) <= 0){
            return false;
        }
        
        
        $returnHtml = '<div class="alert alert-'.$type.' errorMessageWrapper"><ul>';
        
        foreach($message as $mLabel)
        {
            $message = ($escape)?StringUtil::escape($mLabel):$mLabel;
            $returnHtml .= '<li>'.$message.'</li>';
        }
        $returnHtml .= '</ul></div>';
        return $returnHtml;
    }
}
